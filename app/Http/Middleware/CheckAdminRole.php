<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Usamos el método isAdmin() que ya definiste en tu modelo User
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            // Si no es admin, lo redirigimos a su dashboard de cliente.
            return redirect()->route('restaurant.dashboard');
        }

        return $next($request);
    }
}
