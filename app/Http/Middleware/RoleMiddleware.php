<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        $guard = null;

        if (Auth::guard('web')->check()) {
            return redirect()->guest(route('login'));
        } else {
            return redirect()->guest(route('admin.login'));
        }
    }
}