<?php

namespace App\Models\Workpermit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajuanPenyelesaian extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_penyelesaian';

    protected $fillable = [
        'purchase_order_id',
        'alasan',
        'status'
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function approvals()
    {
        return $this->hasMany(ApprovalPenyelesaian::class);
    }
}
