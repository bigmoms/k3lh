<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = ['name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Folder::class, 'parent_id')->with('children');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function getNameWithHierarchyAttribute()
    {
        $names = [$this->name];
        $parent = $this->parent;
        while ($parent) {
            array_unshift($names, $parent->name);
            $parent = $parent->parent;
        }
        return implode(' / ', $names);
    }

    public function getPathHierarchyAttribute()
    {
        $parts = [$this->name];
        $folder = $this->parent;
        while ($folder) {
            array_unshift($parts, $folder->name);
            $folder = $folder->parent;
        }
        return implode('/', $parts);
    }
}
