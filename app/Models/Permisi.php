<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permisi extends Model
{
    use HasFactory;

    protected $table = 'permisi';
    protected $primaryKey = 'id';
}
