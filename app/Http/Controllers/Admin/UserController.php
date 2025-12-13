<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\LogMonitorService;

class UserController extends Controller
{
    public function __construct()
    {
        $this->logMonitor = app(LogMonitorService::class);
        // Pastikan user login DAN role-nya Head
        $this->middleware(['auth', 'role:Admin']);
    }

    /**
     * Tampilkan semua pengguna.
     */
    public function index()
    {
        $this->logMonitor->log('view', 'User Dashboard Viewed');
        $users = User::with('role:id,nama_role')
            ->select('id', 'uuid', 'nama_lengkap', 'email', 'role_id', 'is_active')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Form tambah pengguna baru.
     */
    public function create()
    {
        $this->logMonitor->log('view', 'Create User viewed');
        $roles = Role::select('id', 'nama_role')->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Simpan pengguna baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
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

            DB::commit();
            $this->logMonitor->logCreate(new User(), 'User created');

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logMonitor->logError('create', $e->getMessage(), 'User creation failed', new User());

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
    {
        $this->logMonitor->log('view', 'Edit User viewed');
        $user = User::findOrFail($id);
        $roles = Role::select('id', 'nama_role')->get();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update data pengguna.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
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

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
                $user->save();
            }

            DB::commit();
            $this->logMonitor->logUpdate($user, 'User updated');

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logMonitor->logError('update', $e->getMessage(), 'User update failed', $user);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status aktif/tidak aktif pengguna.
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat mengubah status akun Anda sendiri.'
            ], 403);
        }

        DB::beginTransaction();
        try {
            $user->is_active = !$user->is_active;
            $user->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status user berhasil diubah.',
                'is_active' => $user->is_active
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status user: ' . $e->getMessage()
            ], 500);
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
                ->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
            $this->logMonitor->logDelete($user, 'User deleted');

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logMonitor->logError('destroy', $e->getMessage(), 'User deletion failed', $user);

            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
