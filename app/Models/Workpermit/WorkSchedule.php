<?php

namespace App\Models\Workpermit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    use HasFactory;

    protected $table = 'work_schedules';
    protected $fillable = [
        'purchase_order_id',
        'work_permit_id',
        'periode_laporan',
        'status_approve_she',
        'approved_by',
        'approved_at',
        'alasan_reject',
        'project_manager',
        'lampiran_induction'
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function workPermit()
    {
        return $this->belongsTo(WorkPermit::class, 'work_permit_id');
    }

    public function details()
    {
        return $this->hasMany(WorkScheduleDetail::class, 'work_schedule_id');
    }

    public function hseMonthlyReport()
    {
        return $this->hasOne(HseMonthlyReport::class);
    }

}
