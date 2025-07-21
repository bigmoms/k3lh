<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserDivisi extends Model
{
    use HasFactory;

    protected $table = 'divisi_inspeksi_user';
    protected $primaryKey = 'id';


    protected $fillable = [
        'user_id',
        'divisi_inspeksi_id',
    ];
}
