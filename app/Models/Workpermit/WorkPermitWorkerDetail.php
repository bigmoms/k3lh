<?php
namespace App\Models\Workpermit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPermitWorkerDetail extends Model
{
    use HasFactory;

    protected $table = 'work_permit_worker_details';
    protected $fillable = ['work_permit_worker_id', 'nama', 'lampiran_ktp', 'lampiran_sertifikat'];

    public function workPermitWorker()
    {
        return $this->belongsTo(WorkPermitWorker::class, 'work_permit_worker_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($workerDetail) {
            $workerDetail->workPermitWorker->updateJumlahPekerja();
        });

        static::deleted(function ($workerDetail) {
            $workerDetail->workPermitWorker->updateJumlahPekerja();
        });
    }
}
