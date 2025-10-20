<?php

namespace App\Http\Controllers\Obat;

use App\Http\Controllers\Controller;
use App\Models\KategoriObat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KategoriObatController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin,Karyawan,Kasir']);
    }

    public function index()
    {
        $kategori = KategoriObat::latest()->paginate(10);
        return view('obat.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('obat.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_obat,nama_kategori',
        ]);

        DB::beginTransaction();
        try {
            KategoriObat::create([
                'uuid' => Str::uuid(),
                'nama_kategori' => $validated['nama_kategori'],
            ]);

            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambah kategori: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kategori = KategoriObat::findOrFail($id);
        return view('obat.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_obat,nama_kategori,' . $id,
        ]);

        $kategori = KategoriObat::findOrFail($id);
        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriObat::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
