<?php
namespace App\Mail\Lingkungan;

use App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JadwalPengukuranNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $jadwal;
    public $user;

    public function __construct($jadwal, $user)
    {
        $this->jadwal = $jadwal;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Jadwal Pengukuran Lingkungan Kerja')
            ->view('emails.lingkungan.jadwal_pengukuran');
    }
}
