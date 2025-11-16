<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\StockOpname;
use App\Models\DetailStockOpname;
use App\Models\Obat;
use App\Models\StokBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokOpnameController extends Controller
{
    // Tampilkan form input stock opname (diurutkan per rak)
    public function create()
    {
        // Ambil semua obat yang diurutkan berdasarkan lokasi_rak
        $obats = Obat::withSum('stokBatch as total_stok', 'sisa_stok')
            ->orderBy('lokasi_rak')
            ->get()
            ->groupBy('lokasi_rak'); // Kelompokkan per rak

        return view('shared.stokopname.create', compact('obats'));
    }

    // Simpan hasil input dari karyawan
    public function store(Request $request)
    {
        $request->validate([
            'physical_qty.*' => 'required|integer|min:0',
        ]);

        // Cegah duplikasi opname hari ini
        if (StockOpname::where('tanggal', today())->exists()) {
            return back()->withErrors('Stock opname hari ini sudah dilakukan!');
        }

        // Buat header stock opname
        $opname = StockOpname::create([
            'tanggal' => today(),
            'status' => 'pending',
            'created_by' => auth()->id(),
        ]);

        // Simpan detail per obat
        foreach ($request->physical_qty as $obatId => $physicalQty) {
            $obat = Obat::withSum('stokBatch as total_stok', 'sisa_stok')->findOrFail($obatId);
            DetailStockOpname::create([
                'stock_opname_id' => $opname->id,
                'obat_id' => $obatId,
                'system_qty' => $obat->total_stok ?? 0,
                'physical_qty' => $physicalQty,
                'notes' => $request->notes[$obatId] ?? null,
            ]);
        }

        return redirect()->route('stokopname.index')
            ->with('success', 'Stock opname berhasil disimpan dan menunggu approval admin.');
    }

    // Tampilkan detail untuk approval admin
    public function show($id)
    {
        $opname = StockOpname::with(['details.obat', 'creator'])->findOrFail($id);
        return view('shared.stokopname.show', compact('opname'));
    }

    // Proses approval oleh admin
    public function approve($id)
    {
        $opname = StockOpname::with('details')->findOrFail($id);
        
        // Cegah approval ganda
        if ($opname->status !== 'pending') {
            return back()->withErrors('Stock opname ini sudah diproses!');
        }

        $opname->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Sesuaikan stok secara real-time
        $this->adjustStock($opname);

        return redirect()->route('stokopname.index')
            ->with('success', 'Stock opname disetujui dan stok telah disesuaikan.');
    }

    // Proses penolakan oleh admin
    public function reject($id)
    {
        $opname = StockOpname::findOrFail($id);
        $opname->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('stokopname.index')
            ->with('success', 'Stock opname ditolak. Silakan perbaiki data.');
    }

    // Logika penyesuaian stok (FIFO)
    private function adjustStock(StockOpname $opname)
    {
        foreach ($opname->details as $detail) {
            $variance = $detail->physical_qty - $detail->system_qty;
            if ($variance == 0) continue;

            // Ambil batch obat berdasarkan FIFO (urutkan kadaluarsa)
            $batches = StokBatch::where('obat_id', $detail->obat_id)
                ->orderBy('tgl_kadaluarsa')
                ->get();

            $remaining = abs($variance);
            $sign = $variance > 0 ? 1 : -1; // 1 untuk tambah, -1 untuk kurang

            foreach ($batches as $batch) {
                if ($remaining <= 0) break;

                // Hitung penyesuaian per batch
                $adjustQty = min($batch->sisa_stok, $remaining) * $sign;
                if ($sign < 0 && $batch->sisa_stok < abs($adjustQty)) {
                    $adjustQty = -$batch->sisa_stok; // Pastikan tidak negatif
                }

                // Update batch
                DB::transaction(function () use ($batch, $adjustQty, $detail, $opname) {
                    $batch->decrement('sisa_stok', $adjustQty);

                    // Catat log perubahan stok
                    \App\Models\LogPerubahanStok::create([
                        'obat_id' => $detail->obat_id,
                        'batch_id' => $batch->id,
                        'stok_sebelumnya' => $batch->sisa_stok + $adjustQty,
                        'stok_setelah' => $batch->sisa_stok,
                        'keterangan' => "Penyesuaian stock opname #{$opname->id}",
                        'user_id' => $opname->approved_by,
                        'tipe' => 'adjustment'
                    ]);
                });

                $remaining -= abs($adjustQty);
            }

            // Jika masih ada sisa (stok fisik > sistem)
            if ($remaining > 0 && $sign > 0) {
                $this->createNewBatchForOverage($detail->obat_id, $remaining, $opname->tanggal);
            }
        }
    }

    // Buat batch baru untuk kelebihan stok
    private function createNewBatchForOverage($obatId, $qty, $tanggal)
    {
        $obat = Obat::findOrFail($obatId);
        $latestBatch = StokBatch::where('obat_id', $obatId)
            ->orderByDesc('created_at')
            ->first();

        $newBatch = StokBatch::create([
            'obat_id' => $obatId,
            'no_batch' => 'OPNAME_ADJUSTMENT_' . now()->format('YmdHis'),
            'harga_beli' => $latestBatch ? $latestBatch->harga_beli : 0,
            'harga_jual' => $obat->harga_jual_default ?? ($latestBatch ? $latestBatch->harga_jual : 0),
            'jumlah_masuk' => $qty,
            'sisa_stok' => $qty,
            'tgl_kadaluarsa' => $tanggal->addYears(1), // Default 1 tahun
            'pembelian_id' => null,
        ]);

        // Catat log perubahan
        \App\Models\LogPerubahanStok::create([
            'obat_id' => $obatId,
            'batch_id' => $newBatch->id,
            'stok_sebelumnya' => 0,
            'stok_setelah' => $qty,
            'keterangan' => "Batch baru untuk kelebihan stock opname",
            'user_id' => auth()->id(),
            'tipe' => 'new_batch'
        ]);
    }
}