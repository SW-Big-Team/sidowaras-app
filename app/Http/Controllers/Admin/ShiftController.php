<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\LogMonitorService;

class ShiftController extends Controller
{
    protected $logMonitor;

    public function __construct()
    {
        $this->logMonitor = app(LogMonitorService::class);
        $this->middleware(['auth', 'role:Admin']);
    }

    /**
     * Tampilkan semua shift.
     */
    public function index()
    {
        $this->logMonitor->logView(new Shift(), 'Shift Dashboard Viewed');
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
            $shift = Shift::create([
                'shift_name' => $validated['shift_name'],
                'shift_day_of_week' => $validated['shift_day_of_week'],
                'shift_start' => $validated['shift_start'],
                'shift_end' => $validated['shift_end'],
                'shift_status' => $request->has('shift_status'), // Fix: Checkbox presence determines value
                'user_list' => $validated['user_list'],
            ]);

            DB::commit();

            $this->logMonitor->logCreate($shift, 'Shift created');

            return redirect()
                ->route('admin.shift.index')
                ->with('success', 'Shift berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->logMonitor->logError('create', $e->getMessage(), 'Shift creation failed', $shift);

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
                'shift_status' => $request->has('shift_status'), // Fix: Checkbox presence determines value
                'user_list' => $validated['user_list'],
            ]);

            DB::commit();

            $this->logMonitor->logUpdate($shift, 'Shift updated');

            return redirect()
                ->route('admin.shift.index')
                ->with('success', 'Shift berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->logMonitor->logError('update', $e->getMessage(), 'Shift update failed', $shift);

            return redirect()
                ->route('admin.shift.index')
                ->withInput()
                ->with('error', 'Gagal memperbarui shift: ' . $e->getMessage())
                ->with('_edit_id', $id);
        }
    }

    /**
     * Toggle status shift.
     */
    public function toggleStatus($id)
    {
        $shift = Shift::findOrFail($id);
        if (!$shift) {
            $this->logMonitor->logError('toggleStatus', 'Shift not found', 'Shift status update failed', $shift);
            return redirect()
                ->route('admin.shift.index')
                ->with('error', 'Shift not found');
        }
        $shift->shift_status = !$shift->shift_status;
        $shift->save();

        $this->logMonitor->logUpdate($shift, 'Shift status updated to ' . ($shift->shift_status ? 'Active' : 'Inactive'));

        return redirect()
            ->route('admin.shift.index')
            ->with('success', 'Status shift berhasil diperbarui.');
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

            $this->logMonitor->logDelete($shift, 'Shift deleted');

            return redirect()
                ->route('admin.shift.index')
                ->with('success', 'Shift berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->logMonitor->logError('destroy', $e->getMessage(), 'Shift deletion failed', $shift);

            return redirect()
                ->route('admin.shift.index')
                ->with('error', 'Gagal menghapus shift: ' . $e->getMessage());
        }
    }
}

