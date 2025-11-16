<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Normalize allowed roles
        $allowedRoles = array_map('trim', $roles);

        // 1. ROLE CHECK
        // Admin bypasses everything
        if ($user->role->nama_role !== 'Admin') {
            // User must have allowed role
            if (!in_array($user->role->nama_role, $allowedRoles, true)) {
                abort(403, 'Anda tidak memiliki akses.');
            }
        }

        // 2. ACCOUNT ACTIVE CHECK
        if (!$user->is_active) {
            abort(403, 'Akun Anda tidak aktif.');
        }

        // Admin bypass SHIFT CHECK
        if ($user->role->nama_role === 'Admin') {
            return $next($request);
        }

        // 3. SHIFT CHECK (for non-admins)
        $today = strtolower(Carbon::now()->locale('id')->dayName);
        $now = Carbon::now()->format('H:i:s');

        $shifts = DB::table('shift')
            ->where('shift_status', true)
            ->where('shift_day_of_week', $today)
            ->get();

        // Find shift that contains current user id in user_list JSON
        $currentShift = $shifts->first(function ($shift) use ($user) {
            $list = json_decode($shift->user_list ?? '[]', true);
            return is_array($list) && in_array($user->id, $list);
        });

        if (!$currentShift) {
            abort(403, 'Anda tidak terdaftar pada shift hari ini.');
        }

        // Check time window
        if ($now < $currentShift->shift_start || $now > $currentShift->shift_end) {
            abort(403, 'Anda di luar jam shift.');
        }

        return $next($request);
    }

}
