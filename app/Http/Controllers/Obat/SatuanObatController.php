<?php

namespace App\Http\Controllers\Obat;

use App\Http\Controllers\Controller;
use App\Models\SatuanObat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SatuanObatController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin,Karyawan,Kasir']);
    }

    public function index()
    {
        $satuan = SatuanObat::latest()->paginate(10);
        return view('obat.satuan.index', compact('satuan'));
    }

    public function create()
    {
        return view('obat.satuan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_satuan' => 'required|string|max:50|unique:satuan_obat,nama_satuan',
            'faktor_konversi' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            SatuanObat::create([
                'uuid' => Str::uuid(),
                'nama_satuan' => $validated['nama_satuan'],
                'faktor_konversi' => $validated['faktor_konversi'],
            ]);

            DB::commit();
            return redirect()->route('satuan.index')->with('success', 'Satuan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambah satuan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $satuan = SatuanObat::findOrFail($id);
        return view('obat.satuan.edit', compact('satuan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_satuan' => 'required|string|max:50|unique:satuan_obat,nama_satuan,' . $id,
            'faktor_konversi' => 'required|integer|min:1',
        ]);

        $satuan = SatuanObat::findOrFail($id);
        $satuan->update($validated);

        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $satuan = SatuanObat::findOrFail($id);
        $satuan->delete();

        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil dihapus.');
    }
}
