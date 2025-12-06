<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $query = Obat::with('kategori', 'satuan', 'stokBatches')
                     ->whereHas('stokBatches', fn($q) => $q->where('sisa_stok', '>', 0));

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('kode_obat', 'like', "%{$search}%");
            });
        }

        // Status filter
        $status = $request->input('status');
        if ($status === 'aman') {
            // Stok > minimum
            $query->whereRaw('(SELECT COALESCE(SUM(sisa_stok), 0) FROM stok_batch WHERE stok_batch.obat_id = obat.id) > obat.stok_minimum');
        } elseif ($status === 'rendah') {
            // Stok <= minimum
            $query->whereRaw('(SELECT COALESCE(SUM(sisa_stok), 0) FROM stok_batch WHERE stok_batch.obat_id = obat.id) <= obat.stok_minimum');
        } elseif ($status === 'expired') {
            // Has batches expiring within 30 days
            $query->whereHas('stokBatches', function ($q) {
                $q->where('tgl_kadaluarsa', '<=', now()->addDays(30))
                  ->where('sisa_stok', '>', 0);
            });
        }

        $perPage = $request->input('per_page', 10);
        $obats = $query->latest()->paginate($perPage)->withQueryString();

        return view('shared.stok.index', compact('obats'));
    }
}