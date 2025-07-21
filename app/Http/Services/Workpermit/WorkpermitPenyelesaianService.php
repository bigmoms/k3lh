<?php

namespace App\Http\Services\WorkPermit;

use App\Models\Workpermit\PurchaseOrder;
use App\Models\Workpermit\WorkPermitApprovalLevel;
use App\Models\Workpermit\PengajuanPenyelesaian;
use Illuminate\Support\Facades\Auth;
use App\Mail\PenyelesaianStepApprovedMail;
use Illuminate\Support\Facades\Mail;

class WorkpermitPenyelesaianService
{
    public function ajukan($poId)
    {
        $po = PurchaseOrder::with(['pengajuanPenyelesaian', 'workPermits'])->findOrFail($poId);

        $user = Auth::user();

        if ($po->status === 'cancelled' || $po->status === 'completed') {
            return ['success' => false, 'message' => 'PO tidak valid untuk penyelesaian.'];
        }

        $approvedWP = $po->workPermits->firstWhere('status', 'approved');
        if (!$approvedWP) {
            return ['success' => false, 'message' => 'Belum ada Work Permit yang disetujui.'];
        }

        if ($po->pengajuanPenyelesaian) {
            return ['success' => false, 'message' => 'Sudah pernah diajukan.'];
        }

        $pengajuan = $po->pengajuanPenyelesaian()->create([
            'alasan' => 'Pengajuan penyelesaian pekerjaan oleh vendor',
            'status' => 'draft'
        ]);

        $firstLevel = WorkPermitApprovalLevel::orderBy('level')->first();
        if ($firstLevel) {
            $pengajuan->approvals()->create([
                'permission_name' => $firstLevel->permission_name,
                'level' => $firstLevel->level,
                'status' => 'pending',
            ]);
        }

        return ['success' => true, 'message' => 'Pengajuan penyelesaian berhasil.'];
    }

    public function approveSelesai($id, $user, $request)
    {
        $pengajuan = PengajuanPenyelesaian::findOrFail($id);

        if (!$pengajuan) {
            return ['success' => false, 'message' => 'Pengajuan tidak ditemukan.'];
        }

        $level = $this->getApprovalLevelForUser($user);
        if (!$level) {
            return ['success' => false, 'message' => 'Anda tidak memiliki izin untuk menyetujui.'];
        }

        $approval = $pengajuan->approvals()
            ->where('permission_name', $level->permission_name)
            ->where('level', $level->level)
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

        return $this->processNextApproval($pengajuan, $level->level);
    }

    private function processNextApproval(PengajuanPenyelesaian $penyelesaian, int $currentLevel)
    {
        $nextLevel = $currentLevel + 1;
        $nextApprovalLevel = WorkPermitApprovalLevel::where('level', $nextLevel)->first();

        $vendorId = optional($penyelesaian->purchaseOrder)->vendor_id;
        $vendorUsers = \App\Models\User::where('is_vendor', 1)
            ->where('vendor_id', $vendorId)
            ->whereNotNull('email')
            ->get();

        if ($nextApprovalLevel) {
            $penyelesaian->approvals()->firstOrCreate(
                [
                    'pengajuan_penyelesaian_id' => $penyelesaian->id,
                    'permission_name' => $nextApprovalLevel->permission_name,
                    'level' => $nextLevel,
                ],
                ['status' => 'pending']
            );

            foreach ($vendorUsers as $user) {
                Mail::to($user->email)->send(
                    new \App\Mail\PenyelesaianStepApprovedMail(
                        $penyelesaian,
                        $currentLevel,
                        auth()->user()->name
                    )
                );
            }

            return ['success' => true, 'message' => 'Step disetujui, menunggu approval selanjutnya.'];
        }

        $penyelesaian->update(['status' => 'selesai']);
        $penyelesaian->purchaseOrder()->update(['status' => 'completed']);

        foreach ($vendorUsers as $user) {
            Mail::to($user->email)->send(
                new \App\Mail\PenyelesaianFinalApprovedMail(
                    $penyelesaian,
                    now(),
                    route('permit.po.progres', encodeId($penyelesaian->purchaseOrder->id))
                )
            );
        }

        return ['success' => true, 'message' => 'Penyelesaian disetujui dan PO selesai.'];
    }

    private function getApprovalLevelForUser($user)
    {
        foreach (WorkPermitApprovalLevel::orderBy('level')->get() as $level) {
            if ($user->can($level->permission_name)) {
                return $level;
            }
        }

        return null;
    }

    public function getApprovalDataPenyelesaian(PengajuanPenyelesaian $penyelesaian)
    {
        return $penyelesaian->approvals()
            ->orderBy('level')
            ->get();
    }
}
