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

class ObatController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin,Karyawan,Kasir']);
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

        return view('obat.index', compact('obats', 'search'));
    }

    // Form tambah obat
    public function create()
    {
        $kategori = KategoriObat::all();
        $satuan = SatuanObat::all();
        $kandungan = KandunganObat::all();

        return view('obat.create', compact('kategori', 'satuan', 'kandungan'));
    }

    // Simpan data obat
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kode_obat' => 'nullable|string|max:50|unique:obat,kode_obat',
            'kategori_id' => 'required|exists:kategori_obat,id',
            'satuan_obat_id' => 'required|exists:satuan_obat,id',
            'kandungan_id' => 'nullable|array',
            'kandungan_id.*' => 'exists:kandungan_obat,id',
            'stok_minimum' => 'required|integer|min:0',
            'is_racikan' => 'nullable|boolean',
            'lokasi_rak' => 'nullable|string|max:50',
            'barcode' => 'nullable|string|max:100|unique:obat,barcode',
            'deskripsi' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            Obat::create([
                'uuid' => Str::uuid(),
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
            return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan data obat: ' . $e->getMessage());
        }
    }

    // Form edit obat
    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        $kategori = KategoriObat::all();
        $satuan = SatuanObat::all();
        $kandungan = KandunganObat::all();

        return view('obat.edit', compact('obat', 'kategori', 'satuan', 'kandungan'));
    }


    // Update data obat
    public function update(Request $request, $id)
    {
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
            return redirect()->route('obat.index')->with('success', 'Data obat berhasil diperbarui.');
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
            return redirect()->route('obat.index')->with('success', 'Data obat berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data obat: ' . $e->getMessage());
        }
    }
}
