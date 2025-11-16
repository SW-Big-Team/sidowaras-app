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
            
            $namaKandungan = trim($validated['nama_kandungan']);
            
            $decoded = json_decode($namaKandungan, true);
            if (is_array($decoded) && json_last_error() === JSON_ERROR_NONE) {
                $kandunganArray = array_map(function($item) {
                    return is_array($item) && isset($item['value']) ? trim($item['value']) : trim($item);
                }, $decoded);
            } else {
                if (strpos($namaKandungan, ',') !== false) {

                    $kandunganArray = array_map('trim', explode(',', $namaKandungan));
                } else {
                    // Single value
                    $kandunganArray = [$namaKandungan];
                }
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
        
        // Parse input nama kandungan
        $namaKandungan = trim($validated['nama_kandungan']);
        
        // Cek apakah input berupa JSON dari Tagify
        $decoded = json_decode($namaKandungan, true);
        if (is_array($decoded) && json_last_error() === JSON_ERROR_NONE) {
            // Format dari Tagify: [{"value":"Paracetamol"},{"value":"Caffeine"}]
            $kandunganArray = array_map(function($item) {
                return is_array($item) && isset($item['value']) ? trim($item['value']) : trim($item);
            }, $decoded);
        } else {
            // Plain text, bisa comma-separated atau single value
            if (strpos($namaKandungan, ',') !== false) {
                // Multiple values separated by comma
                $kandunganArray = array_map('trim', explode(',', $namaKandungan));
            } else {
                // Single value
                $kandunganArray = [$namaKandungan];
            }
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
