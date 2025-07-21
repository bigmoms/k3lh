<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pkl extends Model
{
    protected $table = 'pkl';
    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(Pkl::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Pkl::class, 'parent_id');
    }


    // Rekursif: ambil jalur penuh untuk path folder
    public function getPathHierarchyAttribute()
    {
        $names = [$this->name];
        $parent = $this->parent;
        while ($parent) {
            array_unshift($names, $parent->name);
            $parent = $parent->parent;
        }
        return implode('/', $names);
    }
}
