<?php

namespace App\Mail\Inspeksi;

use App\Models\Inspeksi\JadwalInspeksi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;

class HasilInspeksiNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $jadwal;
    public $hasilInspeksi;

    public function __construct(JadwalInspeksi $jadwal, Collection $hasilInspeksi)
    {
        $this->jadwal = $jadwal;
        $this->hasilInspeksi = $hasilInspeksi;
    }

    public function build()
    {
        return $this->subject('Laporan Hasil Inspeksi - ' . tanggalIndo($this->jadwal->tanggal_inspeksi))
            ->view('emails.inspeksi.hasil_inspeksi');
    }
}
