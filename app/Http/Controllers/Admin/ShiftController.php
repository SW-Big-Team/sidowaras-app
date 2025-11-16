<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    /**
     * Tampilkan semua shift.
     */
    public function index()
    {
        $shifts = Shift::orderBy('created_at', 'desc')->get();
        
        // Get users with role "Karyawan" for modal form
        $karyawanRole = Role::where('nama_role', 'Karyawan')->first();
        $karyawanUsers = [];
        
        if ($karyawanRole) {
            $karyawanUsers = User::where('role_id', $karyawanRole->id)
                ->where('is_active', true)
                ->select('id', 'nama_lengkap', 'email')
                ->get();
        }
        
        return view('admin.shift.index', compact('shifts', 'karyawanUsers'));
    }

    /**
     * Form tambah shift baru.
     */
    public function create()
    {
        //
    }

    /**
     * Simpan shift baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shift_name' => 'required|string|max:255',
            'shift_day_of_week' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'shift_start' => 'required|date_format:H:i',
            'shift_end' => 'required|date_format:H:i|after:shift_start',
            'shift_status' => 'nullable|boolean',
            'user_list' => 'required|array|min:1',
            'user_list.*' => 'exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            Shift::create([
                'shift_name' => $validated['shift_name'],
                'shift_day_of_week' => $validated['shift_day_of_week'],
                'shift_start' => $validated['shift_start'],
                'shift_end' => $validated['shift_end'],
                'shift_status' => $validated['shift_status'] ?? true,
                'user_list' => $validated['user_list'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.shift.index')
                ->with('success', 'Shift berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.shift.index')
                ->withInput()
                ->with('error', 'Gagal membuat shift: ' . $e->getMessage());
        }
    }

    /**
     * Form edit shift.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update data shift.
     */
    public function update(Request $request, $id)
    {
        $shift = Shift::findOrFail($id);

        $validated = $request->validate([
            'shift_name' => 'required|string|max:255',
            'shift_day_of_week' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'shift_start' => 'required|date_format:H:i',
            'shift_end' => 'required|date_format:H:i|after:shift_start',
            'shift_status' => 'nullable|boolean',
            'user_list' => 'required|array|min:1',
            'user_list.*' => 'exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            $shift->update([
                'shift_name' => $validated['shift_name'],
                'shift_day_of_week' => $validated['shift_day_of_week'],
                'shift_start' => $validated['shift_start'],
                'shift_end' => $validated['shift_end'],
                'shift_status' => $validated['shift_status'] ?? $shift->shift_status,
                'user_list' => $validated['user_list'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.shift.index')
                ->with('success', 'Shift berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.shift.index')
                ->withInput()
                ->with('error', 'Gagal memperbarui shift: ' . $e->getMessage())
                ->with('_edit_id', $id);
        }
    }

    /**
     * Hapus shift.
     */
    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);

        DB::beginTransaction();
        try {
            $shift->delete();
            DB::commit();

            return redirect()
                ->route('admin.shift.index')
                ->with('success', 'Shift berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.shift.index')
                ->with('error', 'Gagal menghapus shift: ' . $e->getMessage());
        }
    }
}

