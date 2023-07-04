<?php

namespace App\Http\Middleware;

use Closure;

class WebAdminOrEmployeeMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->user() && ($request->user()->role === 'webAdmin' || $request->user()->role === 'webEmployee')) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
