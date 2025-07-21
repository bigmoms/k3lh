<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Workpermit\Vendor;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'kd_vendor',
        'is_active',
        'is_vendor',
        'vendor_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function posts()
    // {
    //     return $this->hasMany(Post::class);
    // }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function lokasiLingkungan()
    {
        return $this->belongsToMany(\App\Models\Lokasi::class, 'user_lokasi_lingkungan', 'user_id', 'lokasi_id');
    }

      public function divisiInspeksi()
    {
        return $this->belongsToMany(Division::class, 'divisi_inspeksi_user', 'user_id', 'divisi_inspeksi_id');
    }
}
