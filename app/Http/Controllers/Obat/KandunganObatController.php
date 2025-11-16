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
        return view('admin.kandungan.index', compact('data'));
    }

    public function create()
    {
        return view('admin.kandungan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kandungan' => 'required|string|max:255',
            'dosis_kandungan' => 'required|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            // Parse Tagify output (JSON array dari tags)
            $namaKandungan = $validated['nama_kandungan'];
            
            // Jika dari Tagify, format: [{"value":"Paracetamol"},{"value":"Caffeine"}]
            // Jika sudah berupa JSON array dari Tagify
            $decoded = json_decode($namaKandungan, true);
            if (is_array($decoded)) {
                // Extract values dari Tagify format
                $kandunganArray = array_map(function($item) {
                    return is_array($item) && isset($item['value']) ? $item['value'] : $item;
                }, $decoded);
            } else {
                // Jika plain text, split by comma
                $kandunganArray = array_map('trim', explode(',', $namaKandungan));
            }

            KandunganObat::create([
                'uuid' => Str::uuid(),
                'nama_kandungan' => $kandunganArray,
                'dosis_kandungan' => $validated['dosis_kandungan'],
            ]);

            DB::commit();
            return redirect()->route('admin.kandungan.index')->with('success', 'Kandungan obat berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambah kandungan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kandungan = KandunganObat::findOrFail($id);
        return view('admin.kandungan.edit', compact('kandungan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kandungan' => 'required|string|max:255',
            'dosis_kandungan' => 'required|string|max:100',
        ]);

        $kandungan = KandunganObat::findOrFail($id);
        
        // Parse Tagify output
        $namaKandungan = $validated['nama_kandungan'];
        
        $decoded = json_decode($namaKandungan, true);
        if (is_array($decoded)) {
            // Extract values dari Tagify format
            $kandunganArray = array_map(function($item) {
                return is_array($item) && isset($item['value']) ? $item['value'] : $item;
            }, $decoded);
        } else {
            // Jika plain text, split by comma
            $kandunganArray = array_map('trim', explode(',', $namaKandungan));
        }

        $kandungan->update([
            'nama_kandungan' => $kandunganArray,
            'dosis_kandungan' => $validated['dosis_kandungan'],
        ]);

        return redirect()->route('admin.kandungan.index')->with('success', 'Kandungan obat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kandungan = KandunganObat::findOrFail($id);
        $kandungan->delete();

        return redirect()->route('admin.kandungan.index')->with('success', 'Kandungan obat berhasil dihapus.');
    }
}
