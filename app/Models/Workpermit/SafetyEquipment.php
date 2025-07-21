<?php

namespace App\Models\Workpermit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafetyEquipment extends Model
{
    use HasFactory;

    protected $table = 'safety_equipment';
    protected $fillable = ['name', 'type'];

    public function jobClassifications()
    {
        return $this->belongsToMany(JobClassification::class, 'job_classification_safety_equipment');
    }
}
