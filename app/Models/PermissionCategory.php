<?php

namespace App\Models;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;

class PermissionCategory extends Model
{
    public function permissions()
    {
       return $this->hasMany(Permission::class, 'category_id');
    }
}
