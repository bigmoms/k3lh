<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLokasiLingkungan extends Model
{
    protected $table = 'user_lokasi_lingkungan';

    protected $fillable = [
        'lokasi_id',
        'user_id',
    ];
}
