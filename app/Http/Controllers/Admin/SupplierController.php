<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\LogMonitorService;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    protected $logMonitor;

    public function __construct(LogMonitorService $logMonitor)
    {
        $this->logMonitor = $logMonitor;
    }

    public function index(Request $request)
    {
        $this->logMonitor->log('view', 'Supplier Dashboard Viewed');
        $query = Supplier::query();

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('supplier_name', 'like', "%{$search}%")
                  ->orWhere('supplier_phone', 'like', "%{$search}%")
                  ->orWhere('supplier_email', 'like', "%{$search}%")
                  ->orWhere('supplier_address', 'like', "%{$search}%");
            });
        }

        // Status filter
        $status = $request->input('status');
        if ($status === 'aktif') {
            $query->where('supplier_status', true);
        } elseif ($status === 'nonaktif') {
            $query->where('supplier_status', false);
        }

        $perPage = $request->input('per_page', 10);
        $suppliers = $query->orderBy('supplier_name')
            ->paginate($perPage)
            ->withQueryString();

        $editingSupplier = null;
        if ($request->has('edit')) {
            $editingSupplier = Supplier::find($request->integer('edit'));
        }

        return view('admin.supplier.index', [
            'suppliers' => $suppliers,
            'editingSupplier' => $editingSupplier,
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'supplier_name' => [
                    'required', 'string', 'max:255',
                    Rule::unique('supplier', 'supplier_name')->whereNull('deleted_at'),
                ],
                'supplier_phone' => ['required', 'string', 'max:50'],
                'supplier_address' => ['nullable', 'string', 'max:500'],
                'supplier_email' => ['nullable', 'email', 'max:255'],
                'supplier_website' => ['nullable', 'string', 'max:255'],
                'supplier_logo' => ['nullable', 'string', 'max:255'],
                'supplier_status' => ['nullable', 'boolean'],
            ]);

            // If a soft-deleted supplier with same name exists, restore and update it
            $trashed = Supplier::withTrashed()
                ->where('supplier_name', $validated['supplier_name'])
                ->first();

            if ($trashed && $trashed->trashed()) {
                $trashed->restore();
                $trashed->fill($validated);
                $trashed->supplier_status = $request->boolean('supplier_status'); // Radio button: 1=aktif, 0=nonaktif
                $trashed->updated_by = optional($request->user())->id;
                $trashed->save();

                return redirect()
                    ->route('admin.supplier.index')
                    ->with('success', 'Supplier restored and updated successfully.');
            }

            $supplier = new Supplier($validated);
            $supplier->supplier_status = $request->boolean('supplier_status'); // Radio button: 1=aktif, 0=nonaktif
            $supplier->created_by = optional($request->user())->id;
            $supplier->updated_by = optional($request->user())->id;
            $supplier->save();

            DB::commit();
            $this->logMonitor->logCreate($supplier, 'Supplier created');

            return redirect()
                ->route('admin.supplier.index')
                ->with('success', 'Supplier created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logMonitor->logError('create', $e->getMessage(), 'Supplier creation failed', $supplier);

            return redirect()
                ->route('admin.supplier.index')
                ->withInput()
                ->with('error', 'Gagal membuat supplier: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Supplier $supplier)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'supplier_name' => [
                    'required', 'string', 'max:255',
                    Rule::unique('supplier', 'supplier_name')
                        ->whereNull('deleted_at')
                        ->ignore($supplier->id, 'id'),
                ],
                'supplier_phone' => ['required', 'string', 'max:50'],
                'supplier_address' => ['nullable', 'string', 'max:500'],
                'supplier_email' => ['nullable', 'email', 'max:255'],
                'supplier_website' => ['nullable', 'string', 'max:255'],
                'supplier_logo' => ['nullable', 'string', 'max:255'],
                'supplier_status' => ['nullable', 'boolean'],
            ]);

            $supplier->fill($validated);
            $supplier->supplier_status = $request->boolean('supplier_status'); // Radio button: 1=aktif, 0=nonaktif
            $supplier->updated_by = optional($request->user())->id;
            $supplier->save();

            DB::commit();
            $this->logMonitor->logUpdate($supplier, 'Supplier updated');

            return redirect()
                ->route('admin.supplier.index')
                ->with('success', 'Supplier updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logMonitor->logError('update', $e->getMessage(), 'Supplier update failed', $supplier);

            return redirect()
                ->route('admin.supplier.index')
                ->withInput()
                ->with('error', 'Gagal memperbarui supplier: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status supplier.
     */
    public function toggleStatus($id)
    {
        $supplier = Supplier::findOrFail($id);
        if (!$supplier) {
            $this->logMonitor->logError('toggleStatus', 'Supplier not found', 'Supplier status update failed', $supplier);
            return redirect()
                ->route('admin.supplier.index')
                ->with('error', 'Supplier not found');
        }
        
        $supplier->supplier_status = !$supplier->supplier_status;
        $supplier->save();

        $this->logMonitor->logUpdate($supplier, 'Supplier status updated');

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Status supplier berhasil diperbarui.');
    }

    public function destroy(Request $request, Supplier $supplier)
    {
        DB::beginTransaction();
        try {
            $supplier->delete();
            DB::commit();
            $this->logMonitor->logDelete($supplier, 'Supplier deleted');

            return redirect()
                ->route('admin.supplier.index')
                ->with('success', 'Supplier deleted (soft) successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logMonitor->logError('destroy', $e->getMessage(), 'Supplier deletion failed', $supplier);

            return redirect()
                ->route('admin.supplier.index')
                ->withInput()
                ->with('error', 'Gagal menghapus supplier: ' . $e->getMessage());
        }
    }
}
