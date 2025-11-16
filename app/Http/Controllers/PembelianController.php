<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\StokBatch;
use App\Models\Obat;
use App\Models\LogPerubahanStok;
use App\Models\PembayaranTermin; // BARU: Import model PembayaranTermin
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException; // BARU: Untuk validasi kustom

class PembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('role:Admin,Karyawan,Kasir')->only([
            'index',
            'show',
            'edit',
            'update'
        ]);

        $this->middleware('role:Admin')->only([
            'create',
            'store',
            'destroy'
        ]);
    }

    public function index()
    {
        $pembelian = Pembelian::with('user')->orderByDesc('created_at')->paginate(15);
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
            'metode_pembayaran' => 'required|in:tunai,non tunai,termin', // MODIFIKASI: Tambah 'termin'
            'tgl_pembelian' => 'required|date',
            'total_harga' => 'required|numeric|min:0',
            'obat' => 'required|array|min:1',
            'obat.*.obat_id' => 'required|exists:obat,id',
            'obat.*.harga_beli' => 'required|numeric|min:0',
            'obat.*.harga_jual' => 'required|numeric|min:0',
            'obat.*.jumlah_masuk' => 'required|integer|min:1',
            'obat.*.tgl_kadaluarsa' => 'required|date|after:today',

            'termin_list' => 'nullable|required_if:metode_pembayaran,termin|array|min:1',
            'termin_list.*.jumlah_bayar' => 'required_if:metode_pembayaran,termin|numeric|min:1',
            'termin_list.*.tgl_jatuh_tempo' => 'required_if:metode_pembayaran,termin|date|after_or_equal:tgl_pembelian',
        ]);

        if ($request->metode_pembayaran == 'termin') {
            $totalTermin = collect($request->termin_list)->sum('jumlah_bayar');
            if (abs((float)$totalTermin - (float)$request->total_harga) > 0.001) {
                 return back()->withErrors(['termin_list' => 'Total dari cicilan termin (Rp ' . number_format($totalTermin, 2) . ') tidak sama dengan Total Harga Pembelian (Rp ' . number_format($request->total_harga, 2) . ').'])->withInput();
            }
        }

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
                if (!$obat) {
                    continue;
                }

                $batch = StokBatch::create([
                    'uuid' => (string) Str::uuid(),
                    'obat_id' => $obat->id,
                    'pembelian_id' => $pembelian->id,
                    'no_batch' => 'BATCH-' . strtoupper(Str::random(8)), // Anda mungkin ingin input no_batch dari form
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
                        'jumlah_bayar' => $terminData['jumlah_bayar'],
                        'tgl_jatuh_tempo' => $terminData['tgl_jatuh_tempo'],
                        'status' => 'belum_lunas', 
                    ]);
                }
            }

            DB::commit();
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
        $obatList = Obat::select('id', 'nama_obat')->orderBy('nama_obat')->get();
        $pembelian->load('stokBatches', 'pembayaranTermin');
        return view('shared.pembelian.edit', compact('pembelian', 'obatList'));
    }

    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::with(['stokBatches', 'pembayaranTermin'])->findOrFail($id);

        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'nama_pengirim' => 'required|string|max:255',
            'no_telepon_pengirim' => 'nullable|string|max:50',
            'metode_pembayaran' => 'required|in:tunai,non tunai,termin', // MODIFIKASI: Tambah 'termin'
            'tgl_pembelian' => 'required|date',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'jumlah_masuk' => 'required|integer|min:1',
            'tgl_kadaluarsa' => 'required|date|after:today',

            // BARU: Validasi untuk termin (sama seperti store)
            'termin_list' => 'nullable|required_if:metode_pembayaran,termin|array|min:1',
            'termin_list.*.jumlah_bayar' => 'required_if:metode_pembayaran,termin|numeric|min:1',
            'termin_list.*.tgl_jatuh_tempo' => 'required_if:metode_pembayaran,termin|date|after_or_equal:tgl_pembelian',
        ]);
        
        // Perhatian: Logika update Anda saat ini mengasumsikan 1 pembelian = 1 batch/obat.
        // Logika termin di bawah ini mengikuti asumsi tersebut.
        $newTotalHarga = $request->harga_beli * $request->jumlah_masuk;

        // BARU: Validasi kustom untuk total termin saat update
        if ($request->metode_pembayaran == 'termin') {
            $totalTermin = collect($request->termin_list)->sum('jumlah_bayar');
            if (abs((float)$totalTermin - (float)$newTotalHarga) > 0.001) {
                return back()->withErrors(['termin_list' => 'Total dari cicilan termin tidak sama dengan Total Harga Pembelian.'])->withInput();
            }
        }

        DB::beginTransaction();
        try {
            $tglPembelian = date('Y-m-d H:i:s', strtotime($request->tgl_pembelian));

            $pembelian->update([
                'nama_pengirim' => $request->nama_pengirim,
                'no_telepon_pengirim' => $request->no_telepon_pengirim,
                'metode_pembayaran' => $request->metode_pembayaran,
                'tgl_pembelian' => $tglPembelian,
                'total_harga' => $newTotalHarga, // Total harga di-update berdasarkan input
            ]);

            // Logika update batch Anda yang sudah ada
            $batch = $pembelian->stokBatches->first();
            if ($batch) {
                $batch->update([
                    'obat_id' => $request->obat_id,
                    'harga_beli' => $request->harga_beli,
                    'harga_jual' => $request->harga_jual,
                    'jumlah_masuk' => $request->jumlah_masuk,
                    'sisa_stok' => $request->jumlah_masuk, // Perhatian: ini me-reset sisa stok
                    'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
                ]);
            }

            // BARU: Logika "Delete all, create new" untuk update termin
            // Ini adalah cara paling sederhana & aman untuk sinkronisasi data termin
            $pembelian->pembayaranTermin()->delete();

            if ($request->metode_pembayaran == 'termin') {
                foreach ($request->termin_list as $index => $terminData) {
                    PembayaranTermin::create([
                        'pembelian_id' => $pembelian->id,
                        'termin_ke' => $index + 1,
                        'jumlah_bayar' => $terminData['jumlah_bayar'],
                        'tgl_jatuh_tempo' => $terminData['tgl_jatuh_tempo'],
                        'status' => 'belum_lunas',
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
}