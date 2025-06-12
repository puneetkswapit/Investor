<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Auth;
class PermissionHelper
{
    public static function check_permission($slugs)
    {
        $user = Auth::user();
        $slugs = explode(',',$slugs);
        foreach ($slugs as $slug) {
            if ($user->permissions->contains('slug', $slug)) {
                return true;
            }
        }
    }

}