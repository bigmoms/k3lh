<?php

namespace App\Models\Workpermit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPermitWorker extends Model
{
    use HasFactory;
    protected $fillable = ['work_permit_id', 'jabatan', 'jumlah'];

    public function workPermit()
    {
        return $this->belongsTo(WorkPermit::class);
    }

    public function workerDetails()
    {
        return $this->hasMany(WorkPermitWorkerDetail::class, 'work_permit_worker_id');
    }

    public function updateJumlahPekerja() {
        $this->jumlah = $this->workerDetails()->count();
        $this->save();
    }
}

