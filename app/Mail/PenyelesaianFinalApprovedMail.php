<?php

namespace App\Mail;

use App\Models\Workpermit\PengajuanPenyelesaian;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PenyelesaianFinalApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $penyelesaian;
    public $tanggal;
    public $linkDetail;

    public function __construct(PengajuanPenyelesaian $penyelesaian, $tanggal, $linkDetail)
    {
        $this->penyelesaian = $penyelesaian;
        $this->tanggal = $tanggal;
        $this->linkDetail = $linkDetail;
    }

    public function build()
    {
        $vendorName = optional($this->penyelesaian->purchaseOrder->vendor)->vendor_name ?? '-';

        return $this->subject('Penyelesaian Pekerjaan Telah Disetujui Sepenuhnya')
            ->view('emails.penyelesaian_final_approved')
            ->with([
                'namaPekerjaan' => optional($this->penyelesaian->purchaseOrder)->nama_pekerjaan ?? '-',
                'vendorName'    => $vendorName,
                'tanggal'       => $this->tanggal,
                'linkDetail'    => $this->linkDetail,
            ]);
    }
}

