<?php

namespace App\Models\Pengukuran;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AktivitasIPBR extends Model
{
    use HasFactory;

    protected $table = 'aktivitas_ipbr';

    protected $fillable = [
        'user_id',
        'batch_id',
        'lokasi_pengukuran_id',
        'aktifitas',
        'tahun',
        'divisi_id',
        'urutan_input'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function lokasiPengukuran()
    {
        return $this->belongsTo(\App\Models\Lokasi::class, 'lokasi_pengukuran_id');
    }

    public function ipbr()
    {
        return $this->hasMany(Ipbr::class, 'aktivitas_ipbr_id');
    }
}
