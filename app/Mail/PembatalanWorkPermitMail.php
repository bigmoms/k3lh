<?php

namespace App\Mail;

use App\Models\Workpermit\PengajuanPembatalan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PembatalanWorkPermitMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pembatalan;

    /**
     * Create a new message instance.
     */
    public function __construct(PengajuanPembatalan $pembatalan)
    {
        $this->pembatalan = $pembatalan;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Pemberitahuan Pembatalan Work Permit')
            ->view('emails.pembatalan_work_permit')
            ->with([
                'pembatalan' => $this->pembatalan,
            ]);
    }
}
