<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        // Pastikan user login DAN role-nya Head
        $this->middleware(['auth', 'role:Admin']);
    }

    /**
     * Tampilkan semua pengguna.
     * Tampilkan semua pengguna.
     */
    public function index()
    {
        $users = User::with('role:id,nama_role')
            ->select('id', 'uuid', 'nama_lengkap', 'email', 'role_id', 'is_active')
            ->get();
        $users = User::with('role:id,nama_role')
            ->select('id', 'uuid', 'nama_lengkap', 'email', 'role_id', 'is_active')
            ->get();

        return view('users.index', compact('users'));
        return view('users.index', compact('users'));
    }

    /**
     * Form tambah pengguna baru.
     * Form tambah pengguna baru.
     */
    public function create()
    {
        $roles = Role::select('id', 'nama_role')->get();
        return view('users.create', compact('roles'));
        $roles = Role::select('id', 'nama_role')->get();
        return view('users.create', compact('roles'));
    }

    /**
     * Simpan pengguna baru.
     * Simpan pengguna baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            User::create([
                'uuid' => Str::uuid(),
                'nama_lengkap' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $validated['role_id'],
                'is_active' => $validated['is_active'] ?? true,
            ]);
        DB::beginTransaction();
        try {
            User::create([
                'uuid' => Str::uuid(),
                'nama_lengkap' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $validated['role_id'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat user: ' . $e->getMessage());
        }
    }

    /**
     * Form edit pengguna.
            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat user: ' . $e->getMessage());
        }
    }

    /**
     * Form edit pengguna.
     */
    public function edit($id)
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::select('id', 'nama_role')->get();

        return view('users.edit', compact('user', 'roles'));
        $user = User::findOrFail($id);
        $roles = Role::select('id', 'nama_role')->get();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update data pengguna.
     * Update data pengguna.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $user->update([
                'nama_lengkap' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'role_id' => $validated['role_id'],
                'is_active' => $validated['is_active'] ?? $user->is_active,
            ]);
        DB::beginTransaction();
        try {
            $user->update([
                'nama_lengkap' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'role_id' => $validated['role_id'],
                'is_active' => $validated['is_active'] ?? $user->is_active,
            ]);

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
                $user->save();
            }
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
                $user->save();
            }

            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    /**
     * Hapus pengguna.
            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    /**
     * Hapus pengguna.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('users.index')
                ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }

        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('users.index')
                ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
