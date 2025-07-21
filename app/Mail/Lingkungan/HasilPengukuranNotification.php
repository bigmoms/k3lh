<?php

namespace App\Mail\Lingkungan;

use App\Mail;
use App\Models\Pengukuran\JadwalPengukuran;
use App\Models\Lokasi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HasilPengukuranNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $jadwal;
    public $lokasi;

    public function __construct(JadwalPengukuran $jadwal, Lokasi $lokasi)
    {
        $this->jadwal = $jadwal;
        $this->lokasi = $lokasi;
    }

    public function build()
    {
        return $this->subject('Notifikasi Hasil Pengukuran Lingkungan Kerja')
            ->view('emails.lingkungan.hasil_pengukuran_notification');
    }
}
