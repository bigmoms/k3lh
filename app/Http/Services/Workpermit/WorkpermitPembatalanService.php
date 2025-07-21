<?php

namespace App\Http\Services\Workpermit;

use App\Models\Workpermit\PengajuanPembatalan;
use App\Models\Workpermit\WorkPermitApprovalLevel;
use App\Models\User;
use App\Mail\PembatalanWorkPermitMail;
use Illuminate\Support\Facades\Mail;

class WorkpermitPembatalanService
{
    public function ajukanPembatalan($request, $user)
    {
        $existing = PengajuanPembatalan::where('purchase_order_id', $request->purchase_order_id)
            ->where('status', '!=', 'ditolak')
            ->first();

        if ($existing) {
            return ['message' => 'Pengajuan pembatalan sudah ada.'];
        }

        $pembatalan = PengajuanPembatalan::create([
            'purchase_order_id' => $request->purchase_order_id,
            'pengaju_id' => $user->id,
            'alasan' => $request->alasan,
            'status' => 'diajukan',
            'approver_id' => null,
        ]);

        $this->addApprovalIfNeeded($pembatalan);

        $vendorId = optional($pembatalan->purchaseOrder)->vendor_id;

        if ($vendorId) {
            $vendorUsers = User::where('is_vendor', 1)
                ->where('vendor_id', $vendorId)
                ->get();

            foreach ($vendorUsers as $vendorUser) {
                if ($vendorUser->email) {
                    Mail::to($vendorUser->email)->send(new PembatalanWorkPermitMail($pembatalan));
                }
            }
        }

        return ['message' => 'Pengajuan pembatalan berhasil diajukan dan email telah dikirim ke vendor.'];
    }

    public function approvePembatalan($id, $user, $request)
    {
        $pembatalan = PengajuanPembatalan::findOrFail($id);

        $approvalLevel = $this->getApprovalLevelForUser($user);

        if (!$approvalLevel) {
            return ['success' => false, 'message' => 'Anda tidak memiliki izin untuk menyetujui.'];
        }

        $approval = $pembatalan->approvals()
            ->where('permission_name', $approvalLevel->permission_name)
            ->where('level', $approvalLevel->level)
            ->where('status', 'pending')
            ->first();

        if (!$approval) {
            return ['success' => false, 'message' => 'Tidak ada approval pending untuk level Anda.'];
        }

        $approval->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approver_id' => $user->id,
            'keterangan' => $request->input('keterangan'),
        ]);

        return $this->processNextApproval($pembatalan, $approvalLevel->level);
    }

    public function rejectPembatalan($id, $user, $request)
    {
        $pembatalan = PengajuanPembatalan::findOrFail($id);
        $approvalLevel = $this->getApprovalLevelForUser($user);

        if (!$approvalLevel) {
            return ['success' => false, 'message' => 'Anda tidak memiliki izin untuk menolak.'];
        }
        $approval = $pembatalan->approvals()
            ->where('permission_name', $approvalLevel->permission_name)
            ->where('level', $approvalLevel->level)
            ->where('status', 'pending')
            ->first();

        if (!$approval) {
            return ['success' => false, 'message' => 'Tidak ada approval pending untuk level Anda.'];
        }
        $approval->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approver_id' => $user->id,
            'keterangan' => $request->input('keterangan'),
        ]);

        $pembatalan->update(['status' => 'ditolak']);

        return ['success' => true, 'message' => 'Pengajuan pembatalan ditolak.'];
    }

    private function getApprovalLevelForUser(User $user)
    {
        $approvalLevels = WorkPermitApprovalLevel::orderBy('level')->get();

        foreach ($approvalLevels as $level) {
            if ($user->can($level->permission_name)) {
                return $level;
            }
        }

        return null;
    }

    private function processNextApproval(PengajuanPembatalan $pembatalan, int $currentLevel)
    {
        $nextLevel = $currentLevel + 1;
        $nextApprovalLevel = WorkPermitApprovalLevel::where('level', $nextLevel)->first();

        if ($nextApprovalLevel) {
            $pembatalan->approvals()->firstOrCreate(
                [
                    'pengajuan_pembatalan_id' => $pembatalan->id,
                    'permission_name' => $nextApprovalLevel->permission_name,
                    'level' => $nextLevel,
                ],
                ['status' => 'pending']
            );

            return response()->json(['success' => true, 'message' => 'Pembatalan disetujui.']);
        }

        $pembatalan->update([
            'status' => 'disetujui',
            'disetujui_pada' => now(),
        ]);

        $pembatalan->purchaseOrder()->update([
            'status' => 'cancelled',
        ]);

        $vendorId = optional($pembatalan->purchaseOrder)->vendor_id;
        if ($vendorId) {
            $vendorUsers = User::where('is_vendor', 1)
                ->where('vendor_id', $vendorId)
                ->get();

            foreach ($vendorUsers as $vendorUser) {
                if ($vendorUser->email) {
                    Mail::to($vendorUser->email)->send(new \App\Mail\PembatalanDisetujuiMail($pembatalan));
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Pembatalan disetujui dan PO dibatalkan.']);
    }

    private function addApprovalIfNeeded(PengajuanPembatalan $pembatalan)
    {
        $firstApprovalLevel = WorkPermitApprovalLevel::first();

        if ($firstApprovalLevel) {
            $pembatalan->approvals()->firstOrCreate(
                [
                    'pengajuan_pembatalan_id' => $pembatalan->id,
                    'permission_name' => $firstApprovalLevel->permission_name,
                    'level' => 1,
                ],
                ['status' => 'pending']
            );
        }
    }

    public function getApprovalDataPembatalan(PengajuanPembatalan $pembatalan)
    {
        return $pembatalan->approvals()
            ->orderBy('level')
            ->get();
    }
}
