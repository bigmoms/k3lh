<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class role_menu_route extends Model
{
    use HasFactory;

    protected $table = 'role_menu_route';
    #protected $primaryKey = 'id';

    protected $fillable = [
        'role_id',
        'menu_id',
        'routenae',

    ];

    public function menu()
    {
        return $this->belongsTo('Menu');
    }

    public function role()
    {
        return $this->belongsTo('Role');
    }
}
