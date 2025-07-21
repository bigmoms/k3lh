<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $primaryKey = 'id';

    protected $fillable = [
        'displaytext',
        'parent_id',
        'sortid',
        'is_active',
        'basedir',
        'linkaddress',
    ];


}
