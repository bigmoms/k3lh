<?php

namespace App\Models\Inspeksi;

use Illuminate\Database\Eloquent\Model;

class SubKategoriInspeksi extends Model
{
    protected $table = 'sub_kategori_inspeksi';

    protected $fillable = [
        'kategori_id',
        'nama_sub_kategori',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriInspeksi::class, 'kategori_id');
    }

    public function cekMateri()
    {
        return $this->hasMany(CekMateriInspeksi::class, 'sub_kategori_id');
    }
}
