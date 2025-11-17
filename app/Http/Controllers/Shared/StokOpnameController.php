<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\StockOpname;
use App\Models\DetailStockOpname;
use App\Models\Obat;
use App\Models\StokBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokOpnameController extends Controller
{
    // Tampilkan form input stock opname (diurutkan per rak)
    public function create()
    {
        // Ambil semua obat yang diurutkan berdasarkan lokasi_rak
        $obats = Obat::withSum('stokBatches as total_stok', 'sisa_stok')
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
            'notes.*' => 'nullable|string|max:500',
        ]);

        // Cegah duplikasi opname hari ini oleh user yang sama
        $existingOpname = StockOpname::where('tanggal', today())
            ->where('created_by', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
            
        if ($existingOpname) {
            return back()->withErrors('Anda sudah melakukan stock opname hari ini yang masih pending atau sudah disetujui!');
        }

        DB::beginTransaction();
        try {
            // Buat header stock opname
            $opname = StockOpname::create([
                'tanggal' => today(),
                'status' => 'pending',
                'created_by' => auth()->id(),
            ]);

            // Simpan detail per obat
            $hasData = false;
            foreach ($request->physical_qty as $obatId => $physicalQty) {
                $obat = Obat::withSum('stokBatches as total_stok', 'sisa_stok')->find($obatId);
                
                if (!$obat) continue;
                
                DetailStockOpname::create([
                    'stock_opname_id' => $opname->id,
                    'obat_id' => $obatId,
                    'system_qty' => $obat->total_stok ?? 0,
                    'physical_qty' => $physicalQty,
                    'notes' => $request->notes[$obatId] ?? null,
                ]);
                $hasData = true;
            }
            
            if (!$hasData) {
                DB::rollBack();
                return back()->withErrors('Tidak ada data yang disimpan. Mohon isi minimal satu item.');
            }

            DB::commit();
            return redirect()->route('stokopname.index')
                ->with('success', 'Stock opname berhasil disimpan dan menunggu approval admin.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Gagal menyimpan stock opname: ' . $e->getMessage());
        }
    }

    // Tampilkan detail untuk approval admin
    public function show($id)
    {
        $opname = StockOpname::with(['details.obat', 'creator'])->findOrFail($id);
        return view('shared.stokopname.show', compact('opname'));
    }

    public function index()
    {
        $opnames = StockOpname::with(['creator'])
            ->latest()
            ->paginate(10);
        
        return view('shared.stokopname.index', compact('opnames'));
    }

    public function pending()
    {
        $pendingOpnames = StockOpname::with(['creator'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);
        
        return view('admin.stokopname.pending', compact('pendingOpnames'));
    }

    // Proses approval oleh admin
    public function approve($id)
    {
        // Authorization check
        if (Auth::user()->role->nama_role !== 'Admin') {
            return back()->withErrors('Hanya Admin yang dapat menyetujui stock opname!');
        }
        
        $opname = StockOpname::with('details.obat')->findOrFail($id);
        
        if ($opname->status !== 'pending') {
            return back()->withErrors('Stock opname ini sudah diproses!');
        }

        DB::beginTransaction();
        try {
            $opname->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Sesuaikan stok secara real-time
            $this->adjustStock($opname);
            
            DB::commit();
            return redirect()->route('admin.stokopname.pending')
                ->with('success', 'Stock opname berhasil disetujui dan stok telah disesuaikan!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Gagal menyetujui stock opname: ' . $e->getMessage());
        }
    }

    // Proses penolakan oleh admin
    public function reject($id)
    {
        // Authorization check
        if (Auth::user()->role->nama_role !== 'Admin') {
            return back()->withErrors('Hanya Admin yang dapat menolak stock opname!');
        }
        
        $opname = StockOpname::findOrFail($id);

        if ($opname->status !== 'pending') {
            return back()->withErrors('Stock opname ini sudah diproses!');
        }
        
        $opname->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

        return redirect()->route('admin.stokopname.pending')
            ->with('success', 'Stock opname berhasil ditolak!');
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
                if ($sign > 0) {
                    // Kelebihan stok: tambah ke batch pertama saja
                    $adjustQty = $remaining;
                } else {
                    // Kekurangan stok: kurangi dari batch (FIFO)
                    $adjustQty = min($batch->sisa_stok, $remaining);
                }

                // Update batch
                DB::transaction(function () use ($batch, $adjustQty, $detail, $opname, $sign) {
                    if ($sign > 0) {
                        $batch->increment('sisa_stok', $adjustQty);
                    } else {
                        $batch->decrement('sisa_stok', $adjustQty);
                    }
                    
                    $stokSebelum = $sign > 0 ? ($batch->sisa_stok - $adjustQty) : ($batch->sisa_stok + $adjustQty);
                    $stokSetelah = $batch->sisa_stok;

                    // Catat log perubahan stok
                    \App\Models\LogPerubahanStok::create([
                        'batch_id' => $batch->id,
                        'stok_sebelum' => $stokSebelum,
                        'stok_sesudah' => $stokSetelah,
                        'keterangan' => "Stock opname adjustment: " . ($sign > 0 ? "+" : "-") . abs($adjustQty) . " unit",
                        'user_id' => auth()->id(),
                    ]);
                });

                $remaining -= $adjustQty;
                
                // Untuk kelebihan stok, cukup update batch pertama
                if ($sign > 0) break;
                
                // Untuk kelebihan stok, cukup update batch pertama
                if ($sign > 0) break;
            }

            // Jika masih ada sisa (stok fisik > sistem dan batch kosong)
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
            'batch_id' => $newBatch->id,
            'stok_sebelum' => 0,
            'stok_sesudah' => $qty,
            'keterangan' => "Batch baru untuk kelebihan stock opname",
            'user_id' => auth()->id(),
        ]);
    }
}