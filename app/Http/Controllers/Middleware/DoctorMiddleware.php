<?php

namespace App\Http\Middleware;

use Closure;

class DoctorMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'doctor') {
            abort(403, 'Доступ только для врачей');
        }
        return $next($request);
    }
}