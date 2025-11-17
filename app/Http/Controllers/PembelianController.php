<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\StokBatch;
use App\Models\Obat;
use App\Models\LogPerubahanStok;
use App\Models\PembayaranTermin;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin,Karyawan,Kasir')->only(['index','show','edit','update']);
        $this->middleware('role:Admin')->only(['create','store','destroy','bayarTermin']);
    }

    public function index()
    {
        $pembelian = Pembelian::with(['user', 'pembayaranTermin']) 
                            ->orderByDesc('created_at')
                            ->paginate(15);
        return view('shared.pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $obatList = Obat::select('id', 'nama_obat', 'barcode')->orderBy('nama_obat')->get();
        return view('shared.pembelian.create', compact('obatList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_faktur' => 'nullable|string|max:100|unique:pembelian,no_faktur',
            'nama_pengirim' => 'required|string|max:100',
            'no_telepon_pengirim' => 'nullable|string|max:20',
            'metode_pembayaran' => 'required|in:tunai,non tunai,termin',
            'tgl_pembelian' => 'required|date',
            'total_harga' => 'required|numeric|min:0',
            'obat' => 'required|array|min:1',
            'obat.*.obat_id' => 'required|exists:obat,id',
            'obat.*.harga_beli' => 'required|numeric|min:0',
            'obat.*.harga_jual' => 'required|numeric|min:0',
            'obat.*.jumlah_masuk' => 'required|integer|min:1',
            'obat.*.tgl_kadaluarsa' => 'required|date|after:today',
            'termin_list' => 'nullable|required_if:metode_pembayaran,termin|array|min:1',
            'termin_list.*.jumlah_bayar' => 'nullable|numeric|min:0',
            'termin_list.*.tgl_jatuh_tempo' => 'required_if:metode_pembayaran,termin|date|after_or_equal:tgl_pembelian',
        ]);

        DB::beginTransaction();
        try {
            $tglPembelian = date('Y-m-d H:i:s', strtotime($request->tgl_pembelian));

            $pembelian = Pembelian::create([
                'uuid' => (string) Str::uuid(),
                'no_faktur' => $request->no_faktur ?: 'INV-' . strtoupper(Str::random(8)),
                'nama_pengirim' => $request->nama_pengirim,
                'no_telepon_pengirim' => $request->no_telepon_pengirim,
                'metode_pembayaran' => $request->metode_pembayaran,
                'tgl_pembelian' => $tglPembelian,
                'total_harga' => $request->total_harga,
                'user_id' => Auth::id(),
            ]);

            foreach ($request->obat as $obatData) {
                $obat = Obat::findOrFail($obatData['obat_id']);
                if (!$obat) continue;

                $batch = StokBatch::create([
                    'uuid' => (string) Str::uuid(),
                    'obat_id' => $obat->id,
                    'pembelian_id' => $pembelian->id,
                    'no_batch' => 'BATCH-' . strtoupper(Str::random(8)),
                    'barcode' => $obat->barcode,
                    'harga_beli' => $obatData['harga_beli'],
                    'harga_jual' => $obatData['harga_jual'],
                    'jumlah_masuk' => $obatData['jumlah_masuk'],
                    'sisa_stok' => $obatData['jumlah_masuk'],
                    'tgl_kadaluarsa' => $obatData['tgl_kadaluarsa'],
                ]);

                LogPerubahanStok::create([
                    'uuid' => (string) Str::uuid(),
                    'batch_id' => $batch->id,
                    'user_id' => Auth::id(),
                    'stok_sebelum' => 0,
                    'stok_sesudah' => $obatData['jumlah_masuk'],
                    'keterangan' => 'Penambahan stok dari pembelian (' . $pembelian->no_faktur . ') - ' . $obat->nama_obat,
                ]);
            }

            if ($pembelian->metode_pembayaran == 'termin') {
                foreach ($request->termin_list as $index => $terminData) {
                    PembayaranTermin::create([
                        'pembelian_id' => $pembelian->id,
                        'termin_ke' => $index + 1,
                        'jumlah_bayar' => $terminData['jumlah_bayar'] ?? 0,
                        'tgl_jatuh_tempo' => $terminData['tgl_jatuh_tempo'],
                        'status' => 'belum_lunas',
                    ]);
                }
            }

            DB::commit();
            
            // Generate notification
            app(NotificationService::class)->notifyPembelianBaru($pembelian);
            
            // Update system notifications (stok menipis mungkin berubah)
            app(NotificationService::class)->generateSystemNotifications();
            
            return redirect()->route('pembelian.index')->with('success', '✅ Pembelian dengan ' . count($request->obat) . ' item obat berhasil disimpan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Pembelian $pembelian)
    {
        $pembelian->load(['user', 'stokBatches.obat', 'pembayaranTermin']);
        return view('shared.pembelian.show', compact('pembelian'));
    }

    public function edit(Pembelian $pembelian)
    {
        $obatList = Obat::select('id', 'nama_obat', 'barcode')->orderBy('nama_obat')->get();
        $pembelian->load('stokBatches', 'pembayaranTermin');
        return view('shared.pembelian.edit', compact('pembelian', 'obatList'));
    }

    /**
     * PERBAIKAN: Gunakan Route Model Binding (Pembelian $pembelian)
     * Ini akan otomatis menemukan pembelian berdasarkan 'uuid' (jika Anda set di model)
     * atau 'id' (default). Ini akan memperbaiki inkonsistensi.
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            // PERBAIKAN: Gunakan $pembelian->id (primary key) untuk rule unique
            'no_faktur' => 'nullable|string|max:100|unique:pembelian,no_faktur,' . $pembelian->id,
            'nama_pengirim' => 'required|string|max:100',
            'no_telepon_pengirim' => 'nullable|string|max:20',
            'metode_pembayaran' => 'required|in:tunai,non tunai,termin',
            'tgl_pembelian' => 'required|date',
            'total_harga' => 'required|numeric|min:0',
            'obat' => 'required|array|min:1',
            'obat.*.obat_id' => 'required|exists:obat,id',
            'obat.*.harga_beli' => 'required|numeric|min:0',
            'obat.*.harga_jual' => 'required|numeric|min:0',
            'obat.*.jumlah_masuk' => 'required|integer|min:1',
            'obat.*.tgl_kadaluarsa' => 'required|date|after:today',
            'termin_list' => 'nullable|required_if:metode_pembayaran,termin|array|min:1',
            'termin_list.*.jumlah_bayar' => 'nullable|numeric|min:0',
            'termin_list.*.tgl_jatuh_tempo' => 'required_if:metode_pembayaran,termin|date|after_or_equal:tgl_pembelian',
        ]);
        
        DB::beginTransaction();
        try {
            $tglPembelian = date('Y-m-d H:i:s', strtotime($request->tgl_pembelian));

            $pembelian->update([
                'no_faktur' => $request->no_faktur ?: 'INV-' . strtoupper(Str::random(8)),
                'nama_pengirim' => $request->nama_pengirim,
                'no_telepon_pengirim' => $request->no_telepon_pengirim,
                'metode_pembayaran' => $request->metode_pembayaran,
                'tgl_pembelian' => $tglPembelian,
                'total_harga' => $request->total_harga,
                // 'user_id' => Auth::id(), // Sebaiknya jangan update user_id
            ]);

            foreach ($pembelian->stokBatches as $batch) {
                LogPerubahanStok::where('batch_id', $batch->id)->delete();
                $batch->delete();
            }

            foreach ($request->obat as $obatData) {
                $obat = Obat::findOrFail($obatData['obat_id']);
                if (!$obat) continue;

                $batch = StokBatch::create([
                    'uuid' => (string) Str::uuid(),
                    'obat_id' => $obat->id,
                    'pembelian_id' => $pembelian->id,
                    'no_batch' => 'BATCH-' . strtoupper(Str::random(8)),
                    'barcode' => $obat->barcode,
                    'harga_beli' => $obatData['harga_beli'],
                    'harga_jual' => $obatData['harga_jual'],
                    'jumlah_masuk' => $obatData['jumlah_masuk'],
                    'sisa_stok' => $obatData['jumlah_masuk'],
                    'tgl_kadaluarsa' => $obatData['tgl_kadaluarsa'],
                ]);

                LogPerubahanStok::create([
                    'uuid' => (string) Str::uuid(),
                    'batch_id' => $batch->id,
                    'user_id' => Auth::id(),
                    'stok_sebelum' => 0, 
                    'stok_sesudah' => $obatData['jumlah_masuk'],
                    'keterangan' => 'Update stok dari edit pembelian (' . $pembelian->no_faktur . ') - ' . $obat->nama_obat,
                ]);
            }
            
            $pembelian->pembayaranTermin()->delete();

            if ($request->metode_pembayaran == 'termin') {
                foreach ($request->termin_list as $index => $terminData) {
                    PembayaranTermin::create([
                        'pembelian_id' => $pembelian->id,
                        'termin_ke' => $index + 1,
                        'jumlah_bayar' => $terminData['jumlah_bayar'] ?? 0,
                        'tgl_jatuh_tempo' => $terminData['tgl_jatuh_tempo'],
                        'status' => $terminData['status'] ?? 'belum_lunas', // Pertahankan status jika ada
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', '✅ Data pembelian berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    public function destroy(Pembelian $pembelian)
    {
        DB::beginTransaction();
        try {
            $pembelian->load('stokBatches');
            foreach ($pembelian->stokBatches as $batch) {
                LogPerubahanStok::where('batch_id', $batch->id)->delete();
                $batch->delete();
            }
            $pembelian->delete();
            DB::commit();
            return redirect()->route('pembelian.index')->with('success', '🗑️ Pembelian dan data terkait berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menghapus: ' . $e->getMessage()]);
        }
    }

    /**
     * BARU: Method untuk memproses pembayaran termin
     */
    public function bayarTermin(Request $request, Pembelian $pembelian)
    {
        $pembelian->load('pembayaranTermin');
        $total_utang = $pembelian->total_harga;
        $total_terbayar = $pembelian->pembayaranTermin->sum('jumlah_bayar');
        $sisa_utang = $total_utang - $total_terbayar;

        $request->validate([
            'jumlah_bayar' => ['required', 'numeric', 'min:1', 'max:' . $sisa_utang],
            'tgl_bayar' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        DB::beginTransaction();
        try {
            $termin_untuk_dicatat = $pembelian->pembayaranTermin
                                        ->where('status', 'belum_lunas')
                                        ->sortBy('termin_ke')
                                        ->first();

            if (!$termin_untuk_dicatat) {
                 return back()->withErrors(['error' => 'Tidak dapat menemukan termin yang belum lunas.']);
            }

            // Logika Akumulasi
            $termin_untuk_dicatat->jumlah_bayar += $request->jumlah_bayar;
            $termin_untuk_dicatat->tgl_bayar = $request->tgl_bayar;
            $termin_untuk_dicatat->keterangan = ($termin_untuk_dicatat->keterangan ?? '') . "\n" 
                . 'Dibayar Rp ' . number_format($request->jumlah_bayar) . ' oleh ' . Auth::user()->nama_lengkap . ' pada ' . $request->tgl_bayar . '. Ket: ' . $request->keterangan;
            
            $total_terbayar_baru = $total_terbayar + $request->jumlah_bayar;

            // Cek Lunas
            if (abs($total_terbayar_baru - $total_utang) < 0.01) {
                foreach($pembelian->pembayaranTermin as $termin) {
                    $termin->status = 'lunas';
                    if(is_null($termin->tgl_bayar)) {
                        $termin->tgl_bayar = $request->tgl_bayar;
                    }
                    $termin->save();
                }
            } else {
                $termin_untuk_dicatat->save();
            }
            
            DB::commit();
            return redirect()->route('pembelian.show', $pembelian->uuid)->with('success', 'Pembayaran berhasil dicatat!');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan pembayaran: ' . $e->getMessage()]);
        }
    }
}