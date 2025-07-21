<?php

namespace App\Models;

use App\Models\Inspeksi\JadwalInspeksi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $table = 'divisions';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nama_divisi',
        'code',
        'lokasi_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'divisi_inspeksi_user', 'divisi_inspeksi_id', 'user_id');
    }

    public function jadwals()
    {
        return $this->hasMany(JadwalInspeksi::class, 'divisi_inspeksi_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }
}
