<?php

namespace App\Models\Inspeksi;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DivisiInspeksiUser extends Pivot
{
    use HasFactory;

    protected $table = 'divisi_inspeksi_user';

    protected $fillable = [
        'user_id',
        'divisi_inspeksi_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'divisi_inspeksi_user');
    }
}
