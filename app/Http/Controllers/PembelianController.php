<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\StokBatch;
use App\Models\Obat;
use App\Models\Supplier;
use App\Models\LogPerubahanStok;
use App\Models\PembayaranTermin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PembelianController extends Controller
{
    // ... (__construct, index, create, show tetap sama) ...
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin,Karyawan,Kasir')->only(['index','show','edit','update']);
        $this->middleware('role:Admin')->only(['create','store','destroy','bayarTermin']);
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $pembelian = Pembelian::with(['user', 'pembayaranTermin'])->orderByDesc('created_at')->paginate($perPage)->withQueryString();
        return view('shared.pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $obatList = Obat::select('id', 'nama_obat', 'barcode')->orderBy('nama_obat')->get();
        $suppliers = Supplier::orderBy('supplier_name')->get();
        return view('shared.pembelian.create', compact('obatList', 'suppliers'));
    }

    public function show(Pembelian $pembelian)
    {
        $pembelian->load(['user', 'stokBatches.obat', 'pembayaranTermin']);
        return view('shared.pembelian.show', compact('pembelian'));
    }

    public function edit(Pembelian $pembelian)
    {
        $obatList = Obat::select('id', 'nama_obat', 'barcode')->orderBy('nama_obat')->get();
        $suppliers = Supplier::orderBy('supplier_name')->get();
        $pembelian->load('stokBatches', 'pembayaranTermin');
        return view('shared.pembelian.edit', compact('pembelian', 'obatList', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_faktur' => 'nullable|string|max:100|unique:pembelian,no_faktur',
            'supplier_id' => 'required|exists:supplier,id',
            'nama_pengirim' => 'nullable|string|max:100', // Optional now
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
            
            // PERUBAHAN: Hapus validasi jumlah_bayar, hanya validasi tanggal
            'termin_list' => 'nullable|required_if:metode_pembayaran,termin|array|min:1',
            'termin_list.*.tgl_jatuh_tempo' => 'required_if:metode_pembayaran,termin|date|after_or_equal:tgl_pembelian',
        ]);

        DB::beginTransaction();
        try {
            $tglPembelian = date('Y-m-d H:i:s', strtotime($request->tgl_pembelian));

            $pembelian = Pembelian::create([
                'uuid' => (string) Str::uuid(),
                'no_faktur' => $request->no_faktur ?: 'INV-' . strtoupper(Str::random(8)),
                'supplier_id' => $request->supplier_id,
                'nama_pengirim' => $request->nama_pengirim ?? Supplier::find($request->supplier_id)->supplier_name,
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
                        'jumlah_bayar' => 0, // PERUBAHAN: Default 0
                        'tgl_jatuh_tempo' => $terminData['tgl_jatuh_tempo'],
                        'status' => 'belum_lunas',
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil disimpan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            'no_faktur' => 'nullable|string|max:100|unique:pembelian,no_faktur,' . $pembelian->id,
            'supplier_id' => 'required|exists:supplier,id',
            'nama_pengirim' => 'nullable|string|max:100',
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
            
            // PERUBAHAN: Hapus validasi jumlah_bayar
            'termin_list' => 'nullable|required_if:metode_pembayaran,termin|array|min:1',
            'termin_list.*.tgl_jatuh_tempo' => 'required_if:metode_pembayaran,termin|date|after_or_equal:tgl_pembelian',
        ]);
        
        DB::beginTransaction();
        try {
            $tglPembelian = date('Y-m-d H:i:s', strtotime($request->tgl_pembelian));

            $pembelian->update([
                'no_faktur' => $request->no_faktur ?: 'INV-' . strtoupper(Str::random(8)),
                'supplier_id' => $request->supplier_id,
                'nama_pengirim' => $request->nama_pengirim ?? Supplier::find($request->supplier_id)->supplier_name,
                'no_telepon_pengirim' => $request->no_telepon_pengirim,
                'metode_pembayaran' => $request->metode_pembayaran,
                'tgl_pembelian' => $tglPembelian,
                'total_harga' => $request->total_harga,
            ]);

            // Hapus stok lama & buat baru (seperti sebelumnya)
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
                        'jumlah_bayar' => 0, // PERUBAHAN: Default 0
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

    public function bayarTermin(Request $request, Pembelian $pembelian)
    {
        // 1. Load data & Hitung Posisi Keuangan
        $pembelian->load('pembayaranTermin');
        
        $total_utang = $pembelian->total_harga;
        $total_terbayar = $pembelian->pembayaranTermin->sum('jumlah_bayar');
        // Gunakan round untuk memastikan presisi angka (misal 1000.00)
        $sisa_utang = round($total_utang - $total_terbayar, 2);

        // 2. Cari "Termin Aktif" (Termin urutan terdepan yang belum diisi uang)
        // Kita gunakan logika: cari yang jumlah_bayar == 0 pertama kali.
        $termin_aktif = $pembelian->pembayaranTermin
                                  ->where('jumlah_bayar', 0)
                                  ->sortBy('termin_ke')
                                  ->first();

        // Validasi: Jika tidak ada termin kosong tersisa, tapi masih ada request masuk
        if (!$termin_aktif) {
            return back()->withErrors(['error' => 'Semua slot termin sudah terisi. Tidak bisa menambah pembayaran lagi.']);
        }

        // 3. Cek apakah ini Termin Terakhir?
        $max_termin = $pembelian->pembayaranTermin->max('termin_ke');
        $is_last_termin = ($termin_aktif->termin_ke == $max_termin);

        // 4. Validasi Input Berdasarkan Case Anda
        $input_bayar = (float) $request->jumlah_bayar;

        // --- CASE: TERMIN TERAKHIR (Strict / Ketat) ---
        if ($is_last_termin) {
            // Logika: Nilai harus sama persis dengan sisa hutang.
            // Gunakan abs() < 100 perak untuk toleransi koma/pembulatan
            if (abs($input_bayar - $sisa_utang) > 100) {
                if ($input_bayar < $sisa_utang) {
                    return back()->withErrors([
                        'jumlah_bayar' => 'Ini termin terakhir. Pembayaran KURANG! Anda wajib melunasi sisa: Rp ' . number_format($sisa_utang, 0, ',', '.')
                    ])->withInput();
                } else {
                    return back()->withErrors([
                        'jumlah_bayar' => 'Ini termin terakhir. Pembayaran LEBIH! Anda hanya perlu membayar: Rp ' . number_format($sisa_utang, 0, ',', '.')
                    ])->withInput();
                }
            }
        } 
        // --- CASE: TERMIN 1, 2, dst (Loose / Bebas) ---
        else {
            // Validasi umum: Tidak boleh bayar lebih dari total sisa hutang
            if ($input_bayar > $sisa_utang) {
                return back()->withErrors([
                    'jumlah_bayar' => 'Pembayaran melebihi total sisa hutang (Rp ' . number_format($sisa_utang, 0, ',', '.') . ').'
                ])->withInput();
            }
            if ($input_bayar <= 0) {
                 return back()->withErrors(['jumlah_bayar' => 'Jumlah bayar harus lebih dari 0.'])->withInput();
            }
        }

        // 5. Simpan Data
        DB::beginTransaction();
        try {
            // Update HANYA termin aktif (tidak looping ke termin lain)
            $termin_aktif->jumlah_bayar = $input_bayar;
            $termin_aktif->tgl_bayar = $request->tgl_bayar;
            $termin_aktif->keterangan = $request->keterangan;
            
            // Tentukan status baris termin ini
            // Jika termin terakhir -> pasti lunas (karena validasi di atas)
            // Jika termin awal -> tetap dianggap 'belum_lunas' kecuali user melunasi seluruh hutang di termin awal
            
            if ($is_last_termin) {
                $termin_aktif->status = 'lunas';
            } else {
                // Jika user melunasi TOTAL hutang di termin 1 (misal), maka termin ini lunas
                // Tapi termin 2 & 3 akan tetap 0 dan belum lunas (sesuai logika slot).
                // Atau Anda bisa membiarkannya 'belum_lunas' sebagai penanda ini cicilan.
                // Disini saya set 'belum_lunas' agar konsisten sebagai cicilan.
                $termin_aktif->status = 'belum_lunas'; 
            }
            
            $termin_aktif->save();

            // 6. Cek Pelunasan Global
            // Jika termin terakhir sudah dibayar, otomatis semua dianggap lunas
            if ($is_last_termin) {
                // Update semua termin menjadi 'lunas' agar data bersih
                $pembelian->pembayaranTermin()->update(['status' => 'lunas']);
            }

            DB::commit();
            return redirect()->route('pembelian.show', $pembelian->uuid)->with('success', 'Pembayaran termin ke-' . $termin_aktif->termin_ke . ' berhasil disimpan!');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }
}