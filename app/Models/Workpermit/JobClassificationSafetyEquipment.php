<?php

namespace App\Models\Workpermit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class JobClassificationSafetyEquipment extends Pivot
{
    use HasFactory;

    protected $table = 'job_classification_safety_equipment';
    protected $fillable = ['job_classification_id', 'safety_equipment_id'];
}
