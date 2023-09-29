<?php

namespace App\Http\Middleware;

use Closure;
use Helper;

class VerifyEmail
{
    public function handle($request, Closure $next)
    {
        if (Helper::config('verify_email') == 1 && auth()->user() && auth()->user()->email_verified_at == NULL) {
            return redirect()->route('verify-email');
        }

        return $next($request);
    }
}
