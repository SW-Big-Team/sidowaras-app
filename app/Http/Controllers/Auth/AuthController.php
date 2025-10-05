<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Email atau password salah']);
        }

        if (!$user->is_active) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Akun Anda belum aktif.']);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        $role = $user->role->nama_role ?? null;
        return match ($role) {
            'Admin' => redirect()->route('/dashboard')->with('success', 'Selamat datang, Admin!'),
            'Karyawan' => redirect('/dashboard')->with('success', 'Selamat datang, Karyawan!'),
            'Kasir' => redirect('/dashboard')->with('success', 'Selamat datang, Kasir!'),
            default => redirect('/dashboard')->with('success', 'Login berhasil.'),
        };
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form')->with('success', 'Logout berhasil.');
    }

    /**
     * Tampilkan profil user yang sedang login.
     */
    public function profile()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.form')->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        return view('auth.profile', compact('user'));
    }
}
