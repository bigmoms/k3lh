<?php

namespace App\Mail;

use App\Models\Workpermit\WorkPermit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InductionScheduledMail extends Mailable
{
    use Queueable, SerializesModels;

    public WorkPermit $workPermit;

    public function __construct(WorkPermit $workPermit)
    {
        $this->workPermit = $workPermit;
    }

    public function build()
    {
        return $this->subject("Jadwal Induction untuk Work Permit")
            ->view('emails.induction_scheduled')
            ->with([
                'vendorName'       => $this->workPermit->vendor->vendor_name ?? '-',
                'namaPekerjaan'    => $this->workPermit->purchaseOrder->nama_pekerjaan ?? '-',
                'tanggalInduction' => $this->workPermit->induction_date
                    ? \Carbon\Carbon::parse($this->workPermit->induction_date)->translatedFormat('d F Y')
                    : '-',
                'lokasi'           => $this->workPermit->purchaseOrder->lokasi_pekerjaan ?? '-',
                'linkDetail'       => route('permit.po.index'),
            ]);
    }
}
