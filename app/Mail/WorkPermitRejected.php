<?php

namespace App\Mail;

use App\Models\Workpermit\WorkPermit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkPermitRejected extends Mailable
{
    use Queueable, SerializesModels;

    public WorkPermit $workPermit;
    public string     $approver;
    public string     $alasan;

    public function __construct(WorkPermit $workPermit, string $approver)
    {
        $this->workPermit = $workPermit;

        $this->approver = $this->humanizeApproval($approver);

        $approval = $workPermit->approvals()
            ->where('permission_name', $approver)
            ->where('status', 'rejected')
            ->latest('approved_at')
            ->first();

        $this->alasan = $approval?->keterangan ?: '-';
    }

    private function humanizeApproval(string $permissionName): string
    {
        $map = [
            'approval-she_officer' => 'SHE Officer',
            'approval-area_owner'  => 'Pemilik Area',
            'approval-supervisor'  => 'Pengawas',
            'approval-she_manager' => 'SHE Manager',
        ];

        return $map[$permissionName] ?? ucwords(str_replace(['-', '_'], ' ', $permissionName));
    }

    public function build()
    {
        $po = $this->workPermit->purchaseOrder;

        return $this->subject("Work Permit – PO #{$po?->no_po} DITOLAK")
            ->view('emails.work_permit_rejected')
            ->with([
                'nomor'         => $po?->no_po ?? '-',
                'namaPekerjaan' => $po?->nama_pekerjaan ?? '-',
                'vendorName'    => $this->workPermit->vendor->vendor_name ?? '-',
                'approver'      => $this->approver,
                'alasan'        => $this->alasan,
                'tanggal'       => now()->translatedFormat('d F Y H:i'),
                'linkIndex'     => route('permit.po.index'),
            ]);
    }
}
