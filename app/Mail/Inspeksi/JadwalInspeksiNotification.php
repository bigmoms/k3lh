<?php
namespace App\Mail\Inspeksi;

use App\Mail;
use App\Models\Inspeksi\JadwalInspeksi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JadwalInspeksiNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $jadwal;

    public function __construct(JadwalInspeksi $jadwal)
    {
        $this->jadwal = $jadwal;
    }

    public function build()
    {
        return $this->subject('Pemberitahuan Jadwal Inspeksi')
            ->view('emails.inspeksi.jadwal_inspeksi_notification')
            ->with([
                'jadwal' => $this->jadwal,
            ]);
    }
}
