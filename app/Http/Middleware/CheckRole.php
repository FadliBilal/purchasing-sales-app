<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request   $request
     * @param  \Closure                   $next
     * @param  mixed                      ...$roles  (e.g. 'super_admin','admin')
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pastikan user sudah login
        if (! Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // Periksa apakah role user masuk dalam daftar yang diizinkan
        if (! in_array(Auth::user()->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
