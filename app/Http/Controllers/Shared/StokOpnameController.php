<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\StockOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LogPerubahanStok;
use App\Models\StokBatch;

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
        $request->validate([
            'tgl_opname' => 'required|date',
            'items' => 'required|array',
            'items.*.obat_id' => 'required|exists:obat,id',
            'items.*.batch_id' => 'required|exists:stok_batch,id',
            'items.*.stok_tercatat' => 'required|integer|min:0',
            'items.*.stok_fisik' => 'required|integer|min:0',
        ]);
    
        // Mulai transaksi
        return DB::transaction(function () use ($request) {
            $opname = StockOpname::create([
                'uuid' => \Illuminate\Support\Str::uuid(),
                'user_id' => auth()->id(),
                'tgl_opname' => $request->tgl_opname,
                'status' => 'SELESAI',
                'keterangan' => $request->keterangan ?? null,
            ]);
    
            foreach ($request->items as $item) {
                // Ambil batch untuk validasi
                $batch = StokBatch::findOrFail($item['batch_id']);
    
                // Hitung selisih
                $selisih = $item['stok_fisik'] - $item['stok_tercatat'];
    
                // Simpan detail opname
                $opname->detail()->create([
                    'uuid' => \Illuminate\Support\Str::uuid(),
                    'batch_id' => $batch->id,
                    'stok_tercatat' => $item['stok_tercatat'],
                    'stok_fisik' => $item['stok_fisik'],
                    'selisih' => $selisih,
                    'keterangan' => $item['keterangan'] ?? null,
                ]);
    
                // Update stok_batch berdasarkan stok_fisik
                $batch->update(['sisa_stok' => $item['stok_fisik']]);
    
                // Catat log perubahan stok
                LogPerubahanStok::create([
                    'uuid' => \Illuminate\Support\Str::uuid(),
                    'batch_id' => $batch->id,
                    'user_id' => auth()->id(),
                    'stok_sebelum' => $item['stok_tercatat'],
                    'stok_sesudah' => $item['stok_fisik'],
                    'keterangan' => "Stok opname: {$opname->uuid}",
                ]);
            }
    
            return redirect()->route('opname.index')
                             ->with('success', 'Stok opname berhasil disimpan dan stok diperbarui.');
        });
    }
}