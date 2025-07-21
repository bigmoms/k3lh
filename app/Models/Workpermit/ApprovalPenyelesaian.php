<?php
namespace App\Models\Workpermit;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApprovalPenyelesaian extends Model
{
    use HasFactory;

    protected $table = 'approval_penyelesaian';

    protected $fillable = [
        'pengajuan_penyelesaian_id',
        'approver_id',
        'status',
        'keterangan',
        'approved_at',
        'permission_name',
        'level'
    ];


    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function pengajuanPenyelesaian()
    {
        return $this->belongsTo(PengajuanPenyelesaian::class, 'pengajuan_penyelesaian_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
