<?php

namespace App\Http\Controllers\Obat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\KategoriObat;
use App\Models\SatuanObat;
use App\Models\KandunganObat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Pembelian;
use App\Models\StokBatch;
use Inertia\Inertia;

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
        $filter = $request->input('filter');
        $kategoriFilter = $request->input('kategori');
        $perPage = $request->input('per_page', 10);

        $query = Obat::with(['kategori'])
            ->withSum('stokBatches as total_stok', 'sisa_stok');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $columns = ['nama_obat', 'kode_obat', 'barcode', 'lokasi_rak', 'deskripsi', 'stok_minimum'];
                foreach ($columns as $col) {
                    $q->orWhere($col, 'like', "%{$search}%");
                }
                $q->orWhereHas('kategori', fn($rel) => $rel->where('nama_kategori', 'like', "%{$search}%"));

                $satuanIds = SatuanObat::where('nama_satuan', 'like', "%{$search}%")->pluck('id')->toArray();
                if (!empty($satuanIds)) {
                    foreach ($satuanIds as $sid) {
                        $q->orWhereJsonContains('satuan_obat_id', $sid);
                    }
                }
            });
        }

        // Filter by kategori
        if ($kategoriFilter) {
            $query->where('kategori_id', $kategoriFilter);
        }

        if ($filter === 'min_stock') {
            $query->whereRaw('(select coalesce(sum(sisa_stok), 0) from stok_batch where stok_batch.obat_id = obat.id) <= obat.stok_minimum');
        } elseif ($filter === 'expired') {
            $query->whereHas('stokBatches', function ($q) {
                $q->where('tgl_kadaluarsa', '<', now())
                    ->where('sisa_stok', '>', 0);
            });
        }

        $obats = $query->latest()->paginate($perPage)->withQueryString();
        $kategoriList = KategoriObat::orderBy('nama_kategori')->get();

        // Hitung obat dengan stok rendah (stok <= stok_minimum)
        $obatStokRendah = Obat::whereRaw('(select coalesce(sum(sisa_stok), 0) from stok_batch where stok_batch.obat_id = obat.id) <= obat.stok_minimum')->count();

        return view('admin.obat.index', compact('obats', 'search', 'kategoriList', 'kategoriFilter', 'obatStokRendah'));
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
            'satuan_obat_id' => 'required|array',
            'satuan_obat_id.*' => 'exists:satuan_obat,id',
            'kandungan_id' => 'nullable|array',
            'kandungan_id.*' => 'exists:kandungan_obat,id',
            'stok_minimum' => 'nullable|integer|min:0',
            'is_racikan' => 'nullable|boolean',
            'lokasi_rak' => 'nullable|string|max:50',
            'barcode' => 'nullable|string|max:100|unique:obat,barcode',
            'deskripsi' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $obat = Obat::create([
                'uuid' => Str::uuid(),
                'nama_obat' => $request->nama_obat,
                'kode_obat' => 'OBAT-' . strtoupper(Str::random(6)),
                'kategori_id' => $request->kategori_id,
                'satuan_obat_id' => $request->satuan_obat_id,
                'kandungan_id' => $request->kandungan_id,
                'stok_minimum' => $request->stok_minimum ?? 10,
                'is_racikan' => false,
                'lokasi_rak' => $request->lokasi_rak,
                'barcode' => $request->barcode,
                'deskripsi' => $request->deskripsi,
            ]);

            DB::commit();
            return redirect()->route('admin.obat.index')
                ->with('success', 'Obat berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
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
            'satuan_obat_id' => 'required|array',
            'satuan_obat_id.*' => 'exists:satuan_obat,id',
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

    /**
     * Download import template
     */
    public function downloadTemplate($format = 'csv')
    {
        if ($format === 'csv') {
            $path = public_path('templates/obat_import_template.csv');
            if (!file_exists($path)) {
                return back()->with('error', 'Template file tidak ditemukan.');
            }
            return response()->download($path, 'template_import_obat.csv');
        }

        return back()->with('error', 'Format tidak didukung.');
    }

    /**
     * Import obat from CSV
     */
    public function import(Request $request)
    {
        if (Auth::user()->role->nama_role !== 'Admin') {
            abort(403, 'Hanya admin yang boleh mengimport data obat.');
        }

        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');

        if (!$handle) {
            return back()->with('error', 'Gagal membaca file.');
        }

        // Skip header row
        $header = fgetcsv($handle);

        $imported = 0;
        $errors = [];
        $rowNumber = 1;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Map CSV columns to data
                $data = [
                    'kode_obat' => trim($row[0] ?? ''),
                    'nama_obat' => trim($row[1] ?? ''),
                    'deskripsi' => trim($row[2] ?? ''),
                    'kategori' => trim($row[3] ?? ''),
                    'satuan' => trim($row[4] ?? ''),
                    'stok_minimum' => trim($row[5] ?? '10'),
                    'is_racikan' => trim($row[6] ?? '0'),
                    'lokasi_rak' => trim($row[7] ?? ''),
                    'barcode' => trim($row[8] ?? ''),
                ];

                // Validate required fields
                if (empty($data['nama_obat'])) {
                    $errors[] = "Baris {$rowNumber}: nama_obat wajib diisi.";
                    continue;
                }

                // Find kategori by name
                $kategori = KategoriObat::where('nama_kategori', $data['kategori'])->first();
                if (!$kategori) {
                    $errors[] = "Baris {$rowNumber}: Kategori '{$data['kategori']}' tidak ditemukan.";
                    continue;
                }

                // Find satuan by name
                $satuan = SatuanObat::where('nama_satuan', $data['satuan'])->first();
                if (!$satuan) {
                    $errors[] = "Baris {$rowNumber}: Satuan '{$data['satuan']}' tidak ditemukan.";
                    continue;
                }

                // Check for duplicate barcode
                if (!empty($data['barcode'])) {
                    $existingBarcode = Obat::where('barcode', $data['barcode'])->exists();
                    if ($existingBarcode) {
                        $errors[] = "Baris {$rowNumber}: Barcode '{$data['barcode']}' sudah digunakan.";
                        continue;
                    }
                }

                // Auto-generate kode_obat if empty
                $kodeObat = $data['kode_obat'];
                if (empty($kodeObat)) {
                    $kodeObat = 'OBAT-' . strtoupper(Str::random(6));
                }

                // Check for duplicate kode_obat
                if (Obat::where('kode_obat', $kodeObat)->exists()) {
                    $kodeObat = 'OBAT-' . strtoupper(Str::random(6));
                }

                // Create obat
                Obat::create([
                    'uuid' => Str::uuid(),
                    'kode_obat' => $kodeObat,
                    'nama_obat' => $data['nama_obat'],
                    'deskripsi' => $data['deskripsi'] ?: null,
                    'kategori_id' => $kategori->id,
                    'satuan_obat_id' => [$satuan->id],
                    'stok_minimum' => (int) ($data['stok_minimum'] ?: 10),
                    'is_racikan' => (bool) $data['is_racikan'],
                    'lokasi_rak' => $data['lokasi_rak'] ?: null,
                    'barcode' => $data['barcode'] ?: null,
                ]);

                $imported++;
            }

            fclose($handle);

            if ($imported > 0) {
                DB::commit();
                $message = "Berhasil mengimport {$imported} data obat.";
                if (!empty($errors)) {
                    $message .= " Terdapat " . count($errors) . " baris yang gagal.";
                }
                return back()->with('success', $message)->with('import_errors', $errors);
            } else {
                DB::rollBack();
                return back()->with('error', 'Tidak ada data yang berhasil diimport.')
                    ->with('import_errors', $errors);
            }
        } catch (\Exception $e) {
            fclose($handle);
            DB::rollBack();
            return back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }
}
