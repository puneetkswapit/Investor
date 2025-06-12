<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$permissionSlugs)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Check if user has **any one** of the permissions
        foreach ($permissionSlugs as $slug) {
            if ($user->permissions->contains('slug', $slug)) {
                return $next($request); // Authorized
            }
        }

        abort(403, 'Unauthorized');
    }

}
