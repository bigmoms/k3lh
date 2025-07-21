<?php
namespace App\Models\Inspeksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TindakLanjutInspeksi extends Model
{
    use HasFactory;

    protected $table = 'tindak_lanjut_inspeksi';
    protected $fillable = [
        'hasil_inspeksi_id',
        'saran_perbaikan',
        'target_penyelesaian',
        'status',
        'telah_diperbaiki',
        'foto_perbaikan',
        'catatan_perbaikan'
    ];

    public function hasilInspeksi()
    {
        return $this->belongsTo(HasilInspeksi::class, 'hasil_inspeksi_id');
    }
}
