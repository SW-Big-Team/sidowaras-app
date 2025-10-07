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
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = Auth::user();

        // Jika user belum login
        if (!$user) {
            return redirect()->route('login');
        }

        // Mendukung beberapa role dipisah koma
        $allowedRoles = array_map('trim', explode(',', $roles));

        if ($user->role->nama_role === 'Admin') {
            return $next($request);
        }

        // Jika role user tidak ada dalam allowed roles
        if (!in_array($user->role->nama_role, $allowedRoles, true)) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
