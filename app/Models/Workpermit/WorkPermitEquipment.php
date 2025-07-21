<?php
namespace App\Models\Workpermit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPermitEquipment extends Model
{
    use HasFactory;
    protected $fillable = ['work_permit_id', 'kategori', 'nama', 'jumlah', 'lampiran_foto'];

    public function workPermit()
    {
        return $this->belongsTo(WorkPermit::class);
    }
}
