<?php

namespace App\Models\Pengukuran;

use App\Models\Lokasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ipbr extends Model
{
    use HasFactory;

    protected $table = 'identifikasi_penilaian_bahaya_resiko';

    protected $fillable = [
        'aktivitas_ipbr_id',
        'potensi_bahaya',
        'dampak_k3',
        'resiko_k3',
        'l',
        'c',
        'total',
        'tingkat_risiko',
        'pengendalian_saat_ini',
        'l_after',
        'c_after',
        'total_after',
        'tingkat_risiko_after',
        'r_n',
        'peraturan_perundangan',
        'pengendalian_lanjutan',
        'no_dampak',
        'peluang',
        'status'
    ];

    public function aktivitas()
    {
        return $this->belongsTo(AktivitasIPBR::class, 'aktivitas_ipbr_id');
    }
}
