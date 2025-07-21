<?php

namespace App\Models\Workpermit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ApprovalPembatalan extends Model
{
    use HasFactory;

    protected $table = 'approval_pembatalan';

    protected $fillable = [
        'pengajuan_pembatalan_id',
        'approver_id',
        'permission_name',
        'level',
        'status',
        'keterangan',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanPembatalan::class, 'pengajuan_pembatalan_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
