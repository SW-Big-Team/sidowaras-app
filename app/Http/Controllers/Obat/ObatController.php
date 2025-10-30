<?php

namespace App\Http\Controllers\Obat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\KategoriObat;
use App\Models\SatuanObat;
use App\Models\KandunganObat;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Pembelian;   
use App\Models\StokBatch; 

class ObatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('role:Admin,Karyawan,Kasir')->only([
            'index', 
            'edit', 
            'update'
        ]);

        $this->middleware('role:Admin')->only([
            'create',     
            'store',     
            'destroy'       
        ]);
    }

    // Menampilkan daftar obat
    public function index(Request $request)
    {
        $search = $request->input('search');

        $obats = Obat::with(['kategori', 'satuan'])
            ->when($search, function ($query, $search) {
                $columns = ['nama_obat', 'kode_obat', 'barcode', 'lokasi_rak', 'deskripsi', 'stok_minimum'];

                $query->where(function ($q) use ($columns, $search) {
                    foreach ($columns as $col) {
                        $q->orWhere($col, 'like', "%{$search}%");
                    }

                    $q->orWhereHas('kategori', fn($rel) => $rel->where('nama_kategori', 'like', "%{$search}%"))
                    ->orWhereHas('satuan', fn($rel) => $rel->where('nama_satuan', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.obat.index', compact('obats', 'search'));
    }

    // Form tambah obat
    public function create()
    {
        $kategori = KategoriObat::all();
        $satuan = SatuanObat::all();
        $kandungan = KandunganObat::all();

        return view('admin.obat.create', compact('kategori', 'satuan', 'kandungan'));

        // return Inertia::render('Admin/CreateObat', [
        //     'kategori' => $kategori,
        //     'satuan' => $satuan,
        //     'kandungan' => $kandungan,
        // ]);
    }

    // Simpan data obat
    public function store(Request $request)
    {
        if (Auth::user()->role->nama_role !== 'Admin') {
            abort(403, 'Hanya admin yang boleh mengelola master data obat.');
        }
    
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_obat,id',
            'satuan_obat_id' => 'required|exists:satuan_obat,id',
            'kandungan_id' => 'nullable|array',
            'kandungan_id.*' => 'exists:kandungan_obat,id',
            'stok_minimum' => 'nullable|integer|min:0',
<<<<<<< HEAD
            'stok_minimum' => 'nullable|integer|min:0',
=======
>>>>>>> 3c117fd (Add Cart functionality and update Bootstrap version)
            'is_racikan' => 'nullable|boolean',
            'lokasi_rak' => 'nullable|string|max:50',
            'barcode' => 'nullable|string|max:100|unique:obat,barcode',
            'deskripsi' => 'nullable|string',
            // Input tambahan untuk stok awal
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gt:harga_beli',
            'stok_awal' => 'required|integer|min:1',
            'tgl_kadaluarsa' => 'required|date|after:today',
            'nama_pengirim' => 'required|string|max:100',
        ]);
    
<<<<<<< HEAD
    
=======
>>>>>>> 3c117fd (Add Cart functionality and update Bootstrap version)
        DB::beginTransaction();
        try {
            // 1. Simpan obat
            $obat = Obat::create([
                'uuid' => Str::uuid(),
                'nama_obat' => $request->nama_obat,
                'kode_obat' => 'OBAT-' . strtoupper(Str::random(6)),
<<<<<<< HEAD
                'kode_obat' => 'OBAT-' . strtoupper(Str::random(6)),
=======
>>>>>>> 3c117fd (Add Cart functionality and update Bootstrap version)
                'kategori_id' => $request->kategori_id,
                'satuan_obat_id' => $request->satuan_obat_id,
                'kandungan_id' => $request->kandungan_id,
                'stok_minimum' => $request->stok_minimum ?? 10,
                'is_racikan' => false,
<<<<<<< HEAD
                'kandungan_id' => $request->kandungan_id,
                'stok_minimum' => $request->stok_minimum ?? 10,
                'is_racikan' => false,
=======
>>>>>>> 3c117fd (Add Cart functionality and update Bootstrap version)
                'lokasi_rak' => $request->lokasi_rak,
                'barcode' => $request->barcode,
                'deskripsi' => $request->deskripsi,
            ]);
    
            // 2. Simpan pembelian
            $pembelian = Pembelian::create([
                'uuid' => Str::uuid(),
                'no_faktur' => 'BELI-' . now()->format('ymd') . Str::random(6),
                'nama_pengirim' => $request->nama_pengirim,
                'metode_pembayaran' => 'tunai',
                'tgl_pembelian' => now(),
                'total_harga' => $request->harga_beli * $request->stok_awal,
                'user_id' => auth()->id(),
            ]);
    
            // 3. Simpan stok batch
            StokBatch::create([
                'uuid' => Str::uuid(),
                'obat_id' => $obat->id,
                'pembelian_id' => $pembelian->uuid,
                'no_batch' => 'BATCH-' . now()->format('ymd') . Str::random(5),
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'jumlah_masuk' => $request->stok_awal,
                'sisa_stok' => $request->stok_awal,
                'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
            ]);
    
            DB::commit();
            return redirect()->route('karyawan.stock.index')
                             ->with('success', 'Obat dan stok awal berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
<<<<<<< HEAD
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
=======
>>>>>>> 3c117fd (Add Cart functionality and update Bootstrap version)
        }
    }

    // Form edit obat
    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        $kategori = KategoriObat::all();
        $satuan = SatuanObat::all();
        $kandungan = KandunganObat::all();

        return view('admin.obat.edit', compact('obat', 'kategori', 'satuan', 'kandungan'));
    }


    // Update data obat
    public function update(Request $request, $id)
    {

        if (Auth::user()->role->nama_role !== 'Admin') {
            abort(403, 'Hanya admin yang boleh mengelola master data obat.');
        }

        $obat = Obat::findOrFail($id);

        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kode_obat' => 'nullable|string|max:50|unique:obat,kode_obat,' . $obat->id,
            'kategori_id' => 'required|exists:kategori_obat,id',
            'satuan_obat_id' => 'required|exists:satuan_obat,id',
            'kandungan_id' => 'nullable|array',
            'kandungan_id.*' => 'exists:kandungan_obat,id',
            'stok_minimum' => 'required|integer|min:0',
            'is_racikan' => 'nullable|boolean',
            'lokasi_rak' => 'nullable|string|max:50',
            'barcode' => 'nullable|string|max:100|unique:obat,barcode,' . $obat->id,
            'deskripsi' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $obat->update([
                'nama_obat' => $request->nama_obat,
                'kode_obat' => $request->kode_obat,
                'kategori_id' => $request->kategori_id,
                'satuan_obat_id' => $request->satuan_obat_id,
                'kandungan_id' => $request->kandungan_id, 
                'stok_minimum' => $request->stok_minimum,
                'is_racikan' => $request->is_racikan ?? false,
                'lokasi_rak' => $request->lokasi_rak,
                'barcode' => $request->barcode,
                'deskripsi' => $request->deskripsi,
            ]);

            DB::commit();
            return redirect()->route('admin.obat.index')->with('success', 'Data obat berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data obat: ' . $e->getMessage());
        }
    }

    // Hapus data obat
    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);

        DB::beginTransaction();
        try {
            $obat->delete();
            DB::commit();
            return redirect()->route('admin.obat.index')->with('success', 'Data obat berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data obat: ' . $e->getMessage());
        }
    }

    public function createForKaryawan()
    {
    $kategori = KategoriObat::all();
    $satuan = SatuanObat::all();
    $kandungan = KandunganObat::all();

    return view('karyawan.inventory.tambah', compact('kategori', 'satuan', 'kandungan'));
    }
    
}
