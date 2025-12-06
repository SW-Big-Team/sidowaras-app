<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
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
            $trashed->supplier_status = $request->has('supplier_status'); // Fix: Checkbox logic
            $trashed->updated_by = optional($request->user())->id;
            $trashed->save();

            return redirect()
                ->route('admin.supplier.index')
                ->with('success', 'Supplier restored and updated successfully.');
        }

        $supplier = new Supplier($validated);
        $supplier->supplier_status = $request->has('supplier_status'); // Fix: Checkbox logic
        $supplier->created_by = optional($request->user())->id;
        $supplier->updated_by = optional($request->user())->id;
        $supplier->save();

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Supplier created successfully.');
    }

    public function update(Request $request, Supplier $supplier)
    {
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
        $supplier->supplier_status = $request->has('supplier_status'); // Fix: Checkbox logic
        $supplier->updated_by = optional($request->user())->id;
        $supplier->save();

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Supplier updated successfully.');
    }

    /**
     * Toggle status supplier.
     */
    public function toggleStatus($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->supplier_status = !$supplier->supplier_status;
        $supplier->save();

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Status supplier berhasil diperbarui.');
    }

    public function destroy(Request $request, Supplier $supplier)
    {
        $supplier->updated_by = optional($request->user())->id;
        $supplier->save();
        $supplier->delete();

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Supplier deleted (soft) successfully.');
    }
}
