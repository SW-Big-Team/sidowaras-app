<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\StokBatch;
use App\Models\Obat;
use App\Models\LogPerubahanStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin,Karyawan,Kasir']);
    }

    public function index()
    {
        $pembelian = Pembelian::with('user')->orderByDesc('created_at')->paginate(15);
        return view('pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $obatList = Obat::select('id', 'nama_obat', 'barcode')->orderBy('nama_obat')->get();
        return view('pembelian.create', compact('obatList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'nama_pengirim' => 'required|string|max:100',
            'no_telepon_pengirim' => 'nullable|string|max:20',
            'metode_pembayaran' => 'required|in:tunai,non tunai',
            'tgl_pembelian' => 'required|date',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'jumlah_masuk' => 'required|integer|min:1',
            'tgl_kadaluarsa' => 'required|date|after:today',
        ]);

        DB::beginTransaction();
        try {
            $tglPembelian = date('Y-m-d H:i:s', strtotime($request->tgl_pembelian));
            $obat = Obat::findOrFail($request->obat_id);

            $pembelian = Pembelian::create([
                'uuid' => (string) Str::uuid(),
                'no_faktur' => 'INV-' . strtoupper(Str::random(6)),
                'nama_pengirim' => $request->nama_pengirim,
                'no_telepon_pengirim' => $request->no_telepon_pengirim,
                'metode_pembayaran' => $request->metode_pembayaran,
                'tgl_pembelian' => $tglPembelian,
                'total_harga' => $request->harga_beli * $request->jumlah_masuk,
                'user_id' => Auth::id(),
            ]);

            $batch = StokBatch::create([
                'uuid' => (string) Str::uuid(),
                'obat_id' => $obat->id,
                'pembelian_id' => $pembelian->id, // pake integer id (FK)
                'no_batch' => 'BATCH-' . strtoupper(Str::random(6)),
                'barcode' => $obat->barcode,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'jumlah_masuk' => $request->jumlah_masuk,
                'sisa_stok' => $request->jumlah_masuk,
                'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
            ]);

            LogPerubahanStok::create([
                'uuid' => (string) Str::uuid(),
                'batch_id' => $batch->id,
                'user_id' => Auth::id(),
                'stok_sebelum' => 0,
                'stok_sesudah' => $request->jumlah_masuk,
                'keterangan' => 'Penambahan stok dari pembelian (' . $pembelian->no_faktur . ')',
            ]);

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', '✅ Pembelian dan stok batch berhasil disimpan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function show(Pembelian $pembelian)
    {
        $pembelian->load(['user', 'stokBatches.obat']);
        return view('pembelian.show', compact('pembelian'));
    }

    public function edit(Pembelian $pembelian)
    {
        $obatList = Obat::select('id', 'nama_obat')->orderBy('nama_obat')->get();
        return view('pembelian.edit', compact('pembelian', 'obatList'));
    }

    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::with('stokBatches')->findOrFail($id);

        $request->validate([
            'obat_id'             => 'required|exists:obat,id',
            'nama_pengirim'       => 'required|string|max:255',
            'no_telepon_pengirim' => 'nullable|string|max:50',
            'metode_pembayaran'   => 'required|in:tunai,non tunai',
            'tgl_pembelian'       => 'required|date',
            'harga_beli'          => 'required|numeric|min:0',
            'harga_jual'          => 'required|numeric|min:0',
            'jumlah_masuk'        => 'required|integer|min:1',
            'tgl_kadaluarsa'      => 'required|date|after:today',
        ]);

        DB::beginTransaction();
        try {
            $tglPembelian = date('Y-m-d H:i:s', strtotime($request->tgl_pembelian));

            $pembelian->update([
                'nama_pengirim'       => $request->nama_pengirim,
                'no_telepon_pengirim' => $request->no_telepon_pengirim,
                'metode_pembayaran'   => $request->metode_pembayaran,
                'tgl_pembelian'       => $tglPembelian,
                'total_harga'         => $request->harga_beli * $request->jumlah_masuk,
            ]);

            $batch = $pembelian->stokBatches->first();
            if ($batch) {
                $batch->update([
                    'obat_id'        => $request->obat_id,
                    'harga_beli'     => $request->harga_beli,
                    'harga_jual'     => $request->harga_jual,
                    'jumlah_masuk'   => $request->jumlah_masuk,
                    'sisa_stok'      => $request->jumlah_masuk,
                    'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
                ]);
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
