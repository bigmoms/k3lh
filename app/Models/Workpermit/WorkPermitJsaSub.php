<?php
namespace App\Models\Workpermit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPermitJsaSub extends Model
{
    use HasFactory;

    protected $table = 'work_permit_jsa_sub';

    protected $fillable = [
        'jsa_id',
        'sub_tahapan',
        'deskripsi_pekerjaan',
        'identifikasi_bahaya',
        'pengendalian_risiko',
        'lampiran_jsa'
    ];

    protected $casts = [
        'deskripsi_pekerjaan' => 'array',
        'identifikasi_bahaya' => 'array',
        'pengendalian_risiko' => 'array',
    ];

    public function jsa()
    {
        return $this->belongsTo(WorkPermitJsa::class, 'jsa_id');
    }
}
