<?php

namespace App\Http\Middleware;

use Closure;

class PatientMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'patient') {
            abort(403, 'Доступ только для пациентов');
        }
        return $next($request);
    }
}