<?php

namespace App\Models\Pengukuran;

use App\Models\Lokasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IdentifikasiAspekDampakLingkungan extends Model
{
    use HasFactory;

    protected $table = 'identifikasi_aspek_dampak_lingkungan';

    protected $fillable = [
        'aktivitas_id',
        'aspek_lingkungan',
        'dampak_lingkungan',
        'risiko_lingkungan',
        'na_be',
        'l_awal',
        'c_awal',
        'total_awal',
        'l_akhir',
        'c_akhir',
        'total_akhir',
        'tingkat_risiko_awal',
        'tingkat_risiko_akhir',
        'pengendalian_saat_ini',
        'pengendalian_lanjutan',
        'peluang',
        'peraturan_perundangan',
        'no_dampak',
        'status',
    ];

    public function aktivitas()
    {
        return $this->belongsTo(AktivitasIADL::class, 'aktivitas_id');
    }

}
