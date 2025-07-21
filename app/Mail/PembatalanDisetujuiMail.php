<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Workpermit\PengajuanPembatalan;

class PembatalanDisetujuiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pembatalan;

    public function __construct(PengajuanPembatalan $pembatalan)
    {
        $this->pembatalan = $pembatalan;
    }

    public function build()
    {
        return $this->subject('Work Permit Anda Telah Dibatalkan')
            ->view('emails.pembatalan_disetujui')
            ->with([
                'vendorName' => optional($this->pembatalan->purchaseOrder->vendor)->vendor_name,
                'namaPekerjaan' => $this->pembatalan->purchaseOrder->nama_pekerjaan,
                'noPO' => $this->pembatalan->purchaseOrder->no_po,
                'tanggalPembatalan' => $this->pembatalan->disetujui_pada,
                'alasan' => $this->pembatalan->alasan,
            ]);
    }
}

