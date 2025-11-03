<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\StockOpname;
use Illuminate\Http\Request;

class StokOpnameController extends Controller
{
    public function index()
    {
        $opnames = StockOpname::with('user')
                               ->latest()
                               ->paginate(10);

        return view('shared.opname.index', compact('opnames'));
    }

    public function create()
    {
        $obats = Obat::with('stokBatches')
                     ->whereHas('stokBatches', fn($q) => $q->where('sisa_stok', '>', 0))
                     ->get();

        return view('shared.opname.create', compact('obats'));
    }

    public function store(Request $request)
    {
        // Hanya karyawan & admin yang boleh input
        $request->validate([
            'tgl_opname' => 'required|date',
            'items' => 'required|array',
            'items.*.obat_id' => 'required|exists:obat,id',
            'items.*.stok_tercatat' => 'required|integer|min:0',
            'items.*.stok_fisik' => 'required|integer|min:0',
        ]);

        $opname = StockOpname::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'user_id' => auth()->id(),
            'tgl_opname' => $request->tgl_opname,
            'status' => 'SELESAI',
            'keterangan' => $request->keterangan ?? null,
        ]);

        foreach ($request->items as $item) {
            $opname->detail()->create([
                'uuid' => \Illuminate\Support\Str::uuid(),
                'batch_id' => $item['batch_id'],
                'stok_tercatat' => $item['stok_tercatat'],
                'stok_fisik' => $item['stok_fisik'],
                'selisih' => $item['stok_fisik'] - $item['stok_tercatat'],
                'keterangan' => $item['keterangan'] ?? null,
            ]);
        }

        return redirect()->route('opname.index')
                         ->with('success', 'Stok opname berhasil disimpan.');
    }
}