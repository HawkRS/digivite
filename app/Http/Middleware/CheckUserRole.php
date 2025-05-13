<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // app/Http/Middleware/CheckUserRole.php
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->rol < 2) {
            return $next($request);
        }

        abort(403, 'No tienes permiso para acceder.');
    }

}
