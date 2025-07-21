<?php

namespace App\Models\Inspeksi;

use Illuminate\Database\Eloquent\Model;

class KategoriInspeksi extends Model
{
    protected $table = 'kategori_inspeksi';

    protected $fillable = [
        'nama_kategori',
    ];

    public function subKategori()
    {
        return $this->hasMany(SubKategoriInspeksi::class, 'kategori_id');
    }
}
