<?php

namespace App\Models\Pengukuran;

use App\Models\Division;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengukuranLingkungan extends Model
{
    use HasFactory;

    protected $table = 'pengukuran_lingkungan';

    protected $fillable = [
        'jadwal_id',
        'divisi_id',
        'cahaya_1',
        'cahaya_2',
        'cahaya_3',
        'cahaya_rata2',
        'suhu_1',
        'suhu_2',
        'suhu_3',
        'suhu_rata2',
        'kelembaban_1',
        'kelembaban_2',
        'kelembaban_3',
        'kelembaban_rata2',
        'kebisingan_1',
        'kebisingan_2',
        'kebisingan_3',
        'kebisingan_rata2',
        'catatan',
    ];

    public function jadwal()
    {
        return $this->belongsTo(JadwalPengukuran::class, 'jadwal_id');
    }
    public function divisis()
    {
        return $this->belongsTo(Division::class, 'divisi_id');
    }
}
