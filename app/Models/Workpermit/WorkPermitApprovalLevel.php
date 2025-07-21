<?php

namespace App\Models\Workpermit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPermitApprovalLevel extends Model
{
    use HasFactory;

    protected $fillable = ['permission_name', 'level'];
}
