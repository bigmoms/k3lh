<?php

namespace App\Models\Workpermit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkScheduleDetail extends Model
{
    use HasFactory;

    protected $table = 'work_schedule_details';
    protected $fillable = [
        'work_schedule_id',
        'work_permit_id',
        'tanggal',
        'jumlah_pekerja',
        'jam_kerja',
        'jumlah_pekerja_lembur',
        'jam_lembur',
        'cuti',
        'ijin',
        'sakit',
        'alpha'
    ];

    public function workSchedule()
    {
        return $this->belongsTo(WorkSchedule::class, 'work_schedule_id');
    }


}
