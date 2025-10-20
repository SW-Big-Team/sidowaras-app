<?php

namespace App\Http\Controllers\Obat;

use App\Http\Controllers\Controller;
use App\Models\KandunganObat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KandunganObatController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin,Karyawan,Kasir']);
    }

    public function index()
    {
        $data = KandunganObat::latest()->paginate(10);
        return view('obat.kandungan.index', compact('data'));
    }

    public function create()
    {
        return view('obat.kandungan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kandungan' => 'required|string|max:255|unique:kandungan_obat,nama_kandungan',
            'dosis_kandungan' => 'required|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            KandunganObat::create([
                'uuid' => Str::uuid(),
                'nama_kandungan' => $validated['nama_kandungan'],
                'dosis_kandungan' => $validated['dosis_kandungan'],
            ]);

            DB::commit();
            return redirect()->route('kandungan.index')->with('success', 'Kandungan obat berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambah kandungan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kandungan = KandunganObat::findOrFail($id);
        return view('obat.kandungan.edit', compact('kandungan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kandungan' => 'required|string|max:255|unique:kandungan_obat,nama_kandungan,' . $id,
            'dosis_kandungan' => 'required|string|max:100',
        ]);

        $kandungan = KandunganObat::findOrFail($id);
        $kandungan->update($validated);

        return redirect()->route('kandungan.index')->with('success', 'Kandungan obat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kandungan = KandunganObat::findOrFail($id);
        $kandungan->delete();

        return redirect()->route('kandungan.index')->with('success', 'Kandungan obat berhasil dihapus.');
    }
}
