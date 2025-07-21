<?php
namespace App\Models\Workpermit;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPermitApproval extends Model
{
    use HasFactory;
    protected $fillable = ['work_permit_id', 'approver_id', 'status', 'keterangan', 'approved_at', 'permission_name', 'level', 'catatan_safety', 'catatan_lain'];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function workPermit()
    {
        return $this->belongsTo(WorkPermit::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
