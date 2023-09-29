<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckDatabaseConnection
{
    public function handle(Request $request, Closure $next)
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return redirect('/install');
        }

        return $next($request);
    }
}
