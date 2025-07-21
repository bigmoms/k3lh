<?php

namespace App\Models\Workpermit;

use App\Models\Workpermit\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobClassification extends Model
{
    use HasFactory;

    protected $table = 'job_classifications';
    protected $fillable = ['name', 'description'];

    public function safetyEquipments()
    {
        return $this->belongsToMany(SafetyEquipment::class, 'job_classification_safety_equipment', 'job_classification_id', 'safety_equipment_id');
    }

    public function apds()
    {
        return $this->belongsToMany(SafetyEquipment::class, 'job_classification_safety_equipment', 'job_classification_id', 'safety_equipment_id')
                    ->where('safety_equipment.type', 'apd');
    }

    public function emergencyEquipments()
    {
        return $this->belongsToMany(SafetyEquipment::class, 'job_classification_safety_equipment', 'job_classification_id', 'safety_equipment_id')
                    ->where('safety_equipment.type', 'perlengkapan_darurat');
    }

    public function purchaseOrders()
    {
        return $this->belongsToMany(PurchaseOrder::class, 'purchase_order_job_classification', 'job_classification_id', 'purchase_order_id');
    }
}
