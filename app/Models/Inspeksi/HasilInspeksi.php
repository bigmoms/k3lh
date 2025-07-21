<?php
namespace App\Models\Inspeksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilInspeksi extends Model
{
    use HasFactory;

    protected $table = 'hasil_inspeksi';
    protected $fillable = [
        'jadwal_inspeksi_id',
        'hasil_inspeksi',
        'hasil_gambar',
    ];

    public function jadwalInspeksi()
    {
        return $this->belongsTo(JadwalInspeksi::class, 'jadwal_inspeksi_id');
    }

    public function tindakLanjut()
    {
        return $this->hasMany(TindakLanjutInspeksi::class, 'hasil_inspeksi_id');
    }


}
