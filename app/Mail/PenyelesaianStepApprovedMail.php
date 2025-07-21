<?php

namespace App\Mail;

use App\Models\Workpermit\PengajuanPenyelesaian;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PenyelesaianStepApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $penyelesaian;
    public $currentStep;
    public $approvedBy;

    public function __construct(PengajuanPenyelesaian $penyelesaian, int $currentStep, string $approvedBy)
    {
        $this->penyelesaian = $penyelesaian;
        $this->currentStep = $currentStep;
        $this->approvedBy = $approvedBy;
    }

    public function build()
    {
        return $this->subject("Penyelesaian Pekerjaan – Step {$this->currentStep} Disetujui")
            ->view('emails.penyelesaian_step_approved')
            ->with([
                'step'          => $this->currentStep,
                'namaPekerjaan' => optional($this->penyelesaian->purchaseOrder)->nama_pekerjaan ?? '-',
                'vendorName'    => optional($this->penyelesaian->purchaseOrder->vendor)->vendor_name ?? '-',
                'approvedBy'    => $this->approvedBy,
                'tanggal'       => now()->translatedFormat('d F Y H:i'),
                'linkDetail'    => route('permit.po.progres', encodeId($this->penyelesaian->purchase_order_id)),
            ]);
    }
}
