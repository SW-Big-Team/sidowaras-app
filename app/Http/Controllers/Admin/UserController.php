<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan halaman daftar semua pengguna.
     */
    public function index()
    {
        // Ambil semua data user beserta relasi rolenya, urutkan dari yang terbaru
        $users = User::with('role')->latest()->paginate(10);

        // Tampilkan view dan kirim data user ke sana
        // Frontend developer akan membuat file 'admin.users.index'
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru.
     */
    public function create()
    {
        // Ambil semua role untuk ditampilkan di form (misalnya dropdown)
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'required|boolean',
        ]);

        User::create([
            'uuid' => Str::uuid(),
            'nama_lengkap' => $validated['nama_lengkap'],
            'username' => $validated['username'],
            'role_id' => $validated['role_id'],
            'password_hash' => Hash::make($validated['password']),
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('users.index')->with('success', 'User baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data pengguna.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Mengupdate data pengguna di database.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:100', Rule::unique('users')->ignore($user->id)],
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed', 
            'is_active' => 'required|boolean',
        ]);

        $user->update([
            'nama_lengkap' => $validated['nama_lengkap'],
            'username' => $validated['username'],
            'role_id' => $validated['role_id'],
            'is_active' => $validated['is_active'],
        ]);

        if ($request->filled('password')) {
            $user->password_hash = Hash::make($request->password);
            $user->save();
        }

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus data pengguna dari database.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }
        
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
