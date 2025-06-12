<?php

namespace App\Models;
use App\Models\PermissionCategory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function permission_category()
    {
        return $this->belongsTo(PermissionCategory::class);
    }
}
