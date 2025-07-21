<?php

namespace App\Models\Workpermit;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPermit extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'vendor_id',
        'telepon_pemohon',
        'pengawas',
        'telepon_pengawas',
        'lampiran_struktur',
        'status',
        'induction_date',
        'last_rejected_by',
        'no_dokumen'
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function equipment()
    {
        return $this->hasMany(WorkPermitEquipment::class);
    }

    public function jsa()
    {
        return $this->hasOne(WorkPermitJsa::class);
    }

    public function workers()
    {
        return $this->hasMany(WorkPermitWorker::class);
    }

    public function approvals()
    {
        return $this->hasMany(WorkPermitApproval::class);
    }

    public function lastRejectedByUser()
    {
        return $this->belongsTo(User::class, 'last_rejected_by');
    }

    public function lastRejectedApproval()
    {
        return $this->approvals()
            ->where('status', 'rejected')
            ->orderByDesc('approved_at')
            ->first();
    }

    public function workSchedules()
    {
        return $this->hasMany(WorkSchedule::class, 'work_permit_id');
    }

}
