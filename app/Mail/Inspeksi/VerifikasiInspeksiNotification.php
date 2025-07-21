<?php
namespace App\Mail\Inspeksi;

use App\Mail;
use App\Models\Inspeksi\JadwalInspeksi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifikasiInspeksiNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $jadwal;

    public function __construct(JadwalInspeksi $jadwal)
    {
        $this->jadwal = $jadwal;
    }

    public function build()
    {
        return $this->subject('Verifikasi Hasil Perbaikan Inspeksi - ' . tanggalIndo($this->jadwal->tanggal_inspeksi))
            ->view('emails.inspeksi.verifikasi_inspeksi');
    }
}
