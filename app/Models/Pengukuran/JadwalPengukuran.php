<?php

namespace App\Models\Pengukuran;

use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalPengukuran extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pengukuran';
    protected $casts = [
        'konfirmasi_lokasi' => 'array',
    ];

    protected $fillable = [
        'lokasi_id',
        'tanggal_pengukuran',
        'jam_mulai',
        'jam_selesai',
        'catatan',
        'status',
        'created_by',
        'status_akhir',
        'verifikasi_oleh',
        'verifikasi_tanggal',
        'konfirmasi_lokasi'
    ];

    public function lokasi()
    {
        return $this->belongsToMany(Lokasi::class, 'jadwal_lokasi', 'jadwal_id', 'lokasi_id')
            ->withTimestamps();
    }

    public function pengukuran()
    {
        return $this->hasMany(PengukuranLingkungan::class, 'jadwal_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verifikasi_oleh');
    }
}
