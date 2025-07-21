<?php

namespace App\Models\Workpermit;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPembatalan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_pembatalan';

    protected $fillable = [
        'purchase_order_id',
        'pengaju_id',
        'alasan',
        'status',
        'dibatalkan_oleh',
        'disetujui_pada',
        'ditolak_pada'
    ];

    protected $casts = [
        'disetujui_pada' => 'datetime',
        'ditolak_pada' => 'datetime',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function pengaju()
    {
        return $this->belongsTo(User::class);
    }

    public function approvals()
    {
        return $this->hasMany(ApprovalPembatalan::class, 'pengajuan_pembatalan_id')->orderBy('level');
    }


}
