<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        // Check if user role matches any valid role
        // if (!in_array($user->role, $roles)) {
        //     abort(403, 'Access denied. You do not have permission.');
        // }

        if (!$user->hasAnyRole($roles)) {
            abort(403, 'Access denied. You do not have permission.');
        }
        

        return $next($request);
    }
 

}
