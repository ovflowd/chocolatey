<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * Class Maintenance.
 */
class Maintenance
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return Config::get('maintenance.enforce') ? response()->json(['error' => 'maintenance'], 503) :
            $next($request);
    }
}
