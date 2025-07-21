<?php

namespace App\Models\Inspeksi;

use App\Models\Division;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalInspeksi extends Model
{
    use HasFactory;

    protected $table = 'jadwal_inspeksi';
    protected $casts = [
        'approved_at' => 'datetime',
        'verifikasi_tanggal' => 'datetime'
    ];

    protected $fillable = [
        'divisi_inspeksi_id',
        'tanggal_inspeksi',
        'jam_mulai',
        'jam_selesai',
        'catatan',
        'status',
        'created_by',
    ];

    public function divisiInspeksi()
    {
        return $this->belongsTo(Division::class, 'divisi_inspeksi_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function hasilInspeksi()
    {
        return $this->hasMany(HasilInspeksi::class, 'jadwal_inspeksi_id');
    }

    public function cekMateriInspeksi()
    {
        return $this->hasMany(CekMateriInspeksi::class, 'jadwal_inspeksi_id');
    }

}
