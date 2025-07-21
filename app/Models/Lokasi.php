<?php

namespace App\Models;

use App\Models\Pengukuran\IdentifikasiAspekDampakLingkungan;
use App\Models\Pengukuran\Ipbr;
use App\Models\Pengukuran\JadwalPengukuran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Division;
use App\Models\Pengukuran\AktivitasIADL;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasis';

    protected $fillable = [
        'nama_lokasi',
    ];

    public function divisis()
    {
        return $this->hasMany(Division::class, 'lokasi_id');
    }

    public function jadwal()
    {
        return $this->belongsToMany(JadwalPengukuran::class, 'jadwal_lokasi', 'lokasi_id', 'jadwal_id')
            ->withTimestamps();
    }

    public function identifikasiAspekDampakLingkungan()
    {
        return $this->hasMany(AktivitasIADL::class);
    }

    public function ipbr()
    {
        return $this->hasMany(Ipbr::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_lokasi_lingkungan', 'lokasi_id', 'user_id');
    }
}
