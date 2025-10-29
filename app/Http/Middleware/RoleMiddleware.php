<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Normalisasi nama role
        $allowedRoles = array_map('trim', $roles);

        if ($user->role->nama_role === 'Admin') {
            return $next($request);
        }

        if (!in_array($user->role->nama_role, $allowedRoles, true)) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }

}
