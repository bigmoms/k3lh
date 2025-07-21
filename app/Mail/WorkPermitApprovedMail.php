<?php

namespace App\Mail;

use App\Models\Workpermit\WorkPermit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkPermitApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $workPermit;

    public function __construct(WorkPermit $workPermit)
    {
        $this->workPermit = $workPermit;
    }

    public function build()
    {
        return $this->subject("Notifikasi: Work Permit Telah Disetujui")
            ->view('emails.work_permit_aktif')
            ->with([
                'vendorName'     => $this->workPermit->vendor->vendor_name,
                'namaPekerjaan'  => $this->workPermit->purchaseOrder->nama_pekerjaan,
                'tanggalMulai'   => $this->workPermit->purchaseOrder->tanggal_mulai,
                'tanggalAkhir'   => $this->workPermit->purchaseOrder->tanggal_akhir,
            ]);
    }
}
