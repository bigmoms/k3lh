<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JamKerjaApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Laporan Jam Kerja Disetujui')
                    ->markdown('emails.jamkerjaapproved')
                    ->with($this->data);
    }
}
