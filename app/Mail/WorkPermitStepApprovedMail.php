<?php

namespace App\Mail;

use App\Models\Workpermit\WorkPermit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkPermitStepApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $workPermit;
    public $currentStep;   // nomor step yg baru LULUS
    public $approvedBy;    // nama user yg menyetujui

    public function __construct(WorkPermit $workPermit, int $currentStep, string $approvedBy)
    {
        $this->workPermit  = $workPermit;
        $this->currentStep = $currentStep;
        $this->approvedBy  = $approvedBy;
    }

    public function build()
    {
        return $this->subject("Work Permit – Step {$this->currentStep} APPROVED")
            ->view('emails.work_permit_step_approved')
            ->with([
                'step'          => $this->currentStep,
                'namaPekerjaan' => optional($this->workPermit->purchaseOrder)->nama_pekerjaan ?? '-',
                'vendorName'    => optional($this->workPermit->vendor)->vendor_name ?? '-',
                'approvedBy'    => $this->approvedBy,
                'tanggal'       => now()->translatedFormat('d F Y H:i'),
                'linkDetail'    => route(
                    'permit.po.progres',
                    ['id' => encodeId($this->workPermit->purchase_order_id)]
                ),
            ]);
    }
}
