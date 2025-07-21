<?php

namespace App\Models\Inspeksi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CekMateriInspeksi extends Model
{
    protected $table = 'cek_materi_inspeksi';

    protected $fillable = [
        'jadwal_inspeksi_id',
        'sub_kategori_id',
        'status',
        'catatan',
    ];

    public function jadwalInspeksi(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Inspeksi\JadwalInspeksi::class, 'jadwal_inspeksi_id');
    }


    public function subKategori(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Inspeksi\SubKategoriInspeksi::class, 'sub_kategori_id');
    }
}
