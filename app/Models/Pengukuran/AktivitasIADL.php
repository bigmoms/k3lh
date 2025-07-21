<?php

namespace App\Models\Pengukuran;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AktivitasIADL extends Model
{
    use HasFactory;

    protected $table = 'aktivitas_iadl';

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

    public function identifikasi()
    {
        return $this->hasMany(IdentifikasiAspekDampakLingkungan::class, 'aktivitas_id');
    }
}
