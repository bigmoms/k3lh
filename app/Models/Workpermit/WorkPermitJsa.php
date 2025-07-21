<?php
namespace App\Models\Workpermit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPermitJsa extends Model
{
    use HasFactory;
    protected $table = 'work_permit_jsa';
    protected $fillable = ['work_permit_id','tahapan'];

    public function workPermit()
    {
        return $this->belongsTo(WorkPermit::class);
    }

    public function subTahapan()
    {
        return $this->hasMany(WorkPermitJsaSub::class, 'jsa_id');
    }

}