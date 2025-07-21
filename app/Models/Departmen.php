<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departmen extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'division_id',
        'dept_name',
        'code',
    ];
}
