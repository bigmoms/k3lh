<?php

namespace App\Http\Services\Workpermit;

use App\Models\User;
use App\Models\Workpermit\WorkPermit;
use App\Models\Workpermit\WorkPermitApprovalLevel;
use App\Mail\WorkPermitStepApprovedMail;
use App\Mail\WorkPermitApprovedMail;
use App\Mail\WorkPermitRejected;
use App\Mail\InductionScheduledMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WorkPermitApproveService
{
    public function approveWorkPermit(WorkPermit $workPermit, User $user, Request $request)
    {
        $userLevel = $this->getUserApprovalLevel($user);
        if (!$userLevel) {
            return response()->json(["success" => false, "message" => "Anda tidak memiliki izin untuk menyetujui."], 403);
        }

        $approval = $workPermit->approvals()
            ->where('level', $userLevel->level)
            ->where('permission_name', $userLevel->permission_name)
            ->where('status', 'pending')
            ->first();

        if (!$approval) {
            return response()->json(["success" => false, "message" => "Tidak ada approval pending untuk level Anda."], 403);
        }

        if ($userLevel->permission_name === 'approval-she_officer') {
            $request->validate([
                "induction_date" => [
                    "required",
                    "date",
                    function ($attribute, $value, $fail) use ($workPermit) {
                        if ($value < $workPermit->purchaseOrder->tanggal_mulai || $value > $workPermit->purchaseOrder->tanggal_akhir) {
                            $fail("Tanggal induction harus di antara tanggal mulai dan tanggal akhir PO.");
                        }
                    },
                ],
                "catatan_safety" => "nullable|string|max:1000",
                "catatan_lain" => "nullable|string|max:1000",
            ]);

            $workPermit->update([
                "induction_date" => $request->input("induction_date"),
                "catatan_safety" => $request->input("catatan_safety"),
                "catatan_lain" => $request->input("catatan_lain"),
            ]);

            $vendorUsers = User::where('is_vendor', 1)
                ->where('vendor_id', $workPermit->vendor_id)
                ->get();

            foreach ($vendorUsers as $vendorUser) {
                if ($vendorUser->email) {
                    Mail::to($vendorUser->email)->send(new InductionScheduledMail($workPermit));
                }
            }
        }

        $approval->update([
            "status" => "approved",
            "keterangan" => $request->input("keterangan"),
            "approved_at" => now(),
            "approver_id" => $user->id,
            "catatan_safety" => $request->input("catatan_safety"),
            "catatan_lain" => $request->input("catatan_lain"),
        ]);

        return $this->prosesNextApprove($workPermit, $userLevel->level, $user);
    }

    public function rejectWorkPermit(WorkPermit $workPermit, User $user, Request $request)
    {
        $userLevel = $this->getUserApprovalLevel($user);
        if (!$userLevel) {
            return response()->json(["success" => false, "message" => "Anda tidak memiliki izin untuk menolak."], 403);
        }

        $approval = $workPermit->approvals()
            ->where('level', $userLevel->level)
            ->where('permission_name', $userLevel->permission_name)
            ->where('status', 'pending')
            ->first();

        if (!$approval) {
            return response()->json(["success" => false, "message" => "Tidak ada approval pending untuk level Anda."], 403);
        }

        $approval->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approver_id' => $user->id,
            'keterangan' => $request->input('keterangan'),
        ]);

        $workPermit->update([
            'status' => 'rejected',
            'last_rejected_by' => $userLevel->permission_name,
        ]);

        $vendorUsers = User::where('is_vendor', 1)
            ->where('vendor_id', $workPermit->vendor_id)
            ->whereNotNull('email')
            ->get();

        foreach ($vendorUsers as $vUser) {
            Mail::to($vUser->email)->send(new WorkPermitRejected(
                $workPermit,
                $userLevel->permission_name,
                $request->input('keterangan')
            ));
        }

        return response()->json([
            'success' => true,
            'message' => 'Work Permit ditolak oleh ' . ucwords(str_replace('_', ' ', $userLevel->permission_name)),
        ]);
    }

    private function prosesNextApprove(WorkPermit $workPermit, int $currentLevel, User $approver)
    {
        $nextLevelRow = WorkPermitApprovalLevel::where('level', $currentLevel + 1)->first();

        if ($nextLevelRow) {
            $workPermit->approvals()->firstOrCreate(
                [
                    'work_permit_id'  => $workPermit->id,
                    'permission_name' => $nextLevelRow->permission_name,
                    'level'           => $nextLevelRow->level,
                ],
                ['status' => 'pending']
            );
        } else {
            $workPermit->update(['status' => 'approved']);
            $workPermit->purchaseOrder?->update(['status' => 'active']);
        }

        $vendorUsers = User::where('is_vendor', 1)
            ->where('vendor_id', $workPermit->vendor_id)
            ->whereNotNull('email')
            ->get();

        foreach ($vendorUsers as $user) {
            if ($nextLevelRow) {
                Mail::to($user->email)->send(
                    new WorkPermitStepApprovedMail(
                        $workPermit,
                        $currentLevel,
                        $approver->name
                    )
                );
            } else {
                Mail::to($user->email)->send(
                    new WorkPermitApprovedMail($workPermit)
                );
            }
        }

        return response()->json([
            "success" => true,
            "message" => "Work Permit disetujui."
        ]);
    }

    private function getUserApprovalLevel(User $user)
    {
        $levels = WorkPermitApprovalLevel::orderBy('level')->get();
        foreach ($levels as $level) {
            if ($user->can($level->permission_name)) {
                return $level;
            }
        }
        return null;
    }
}
