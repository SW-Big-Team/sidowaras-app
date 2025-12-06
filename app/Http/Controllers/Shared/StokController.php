<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\StokBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $query = Obat::with('kategori', 'satuan', 'stokBatches')
                     ->whereHas('stokBatches', fn($q) => $q->where('sisa_stok', '>', 0));

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('kode_obat', 'like', "%{$search}%");
            });
        }

        // Status filter
        $status = $request->input('status');
        if ($status === 'aman') {
            // Stok > minimum
            $query->whereRaw('(SELECT COALESCE(SUM(sisa_stok), 0) FROM stok_batch WHERE stok_batch.obat_id = obat.id) > obat.stok_minimum');
        } elseif ($status === 'rendah') {
            // Stok <= minimum
            $query->whereRaw('(SELECT COALESCE(SUM(sisa_stok), 0) FROM stok_batch WHERE stok_batch.obat_id = obat.id) <= obat.stok_minimum');
        } elseif ($status === 'expired') {
            // Has batches expiring within 30 days
            $query->whereHas('stokBatches', function ($q) {
                $q->where('tgl_kadaluarsa', '<=', now()->addDays(30))
                  ->where('sisa_stok', '>', 0);
            });
        }

        $perPage = $request->input('per_page', 10);
        $obats = $query->latest()->paginate($perPage)->withQueryString();

        return view('shared.stok.index', compact('obats'));
    }

    /**
     * Download stok import template
     */
    public function downloadTemplate($format = 'csv')
    {
        if ($format === 'csv') {
            $path = public_path('templates/stok_import_template.csv');
            if (!file_exists($path)) {
                return back()->with('error', 'Template file tidak ditemukan.');
            }
            return response()->download($path, 'template_import_stok.csv');
        }

        return back()->with('error', 'Format tidak didukung.');
    }

    /**
     * Import stok from CSV
     */
    public function importStok(Request $request)
    {
        if (!in_array(Auth::user()->role->nama_role, ['Admin'])) {
            abort(403, 'Hanya admin yang boleh mengimport data stok.');
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
                    'no_batch' => trim($row[1] ?? ''),
                    'harga_beli' => trim($row[2] ?? '0'),
                    'harga_jual' => trim($row[3] ?? '0'),
                    'jumlah' => trim($row[4] ?? '0'),
                    'tgl_kadaluarsa' => trim($row[5] ?? ''),
                ];

                // Validate required fields
                if (empty($data['kode_obat'])) {
                    $errors[] = "Baris {$rowNumber}: kode_obat wajib diisi.";
                    continue;
                }

                if (empty($data['jumlah']) || (int)$data['jumlah'] <= 0) {
                    $errors[] = "Baris {$rowNumber}: jumlah harus lebih dari 0.";
                    continue;
                }

                if (empty($data['tgl_kadaluarsa'])) {
                    $errors[] = "Baris {$rowNumber}: tgl_kadaluarsa wajib diisi (format: YYYY-MM-DD).";
                    continue;
                }

                // Find obat by kode_obat
                $obat = Obat::where('kode_obat', $data['kode_obat'])->first();
                if (!$obat) {
                    $errors[] = "Baris {$rowNumber}: Obat dengan kode '{$data['kode_obat']}' tidak ditemukan.";
                    continue;
                }

                // Parse date
                try {
                    $tglKadaluarsa = \Carbon\Carbon::parse($data['tgl_kadaluarsa']);
                } catch (\Exception $e) {
                    $errors[] = "Baris {$rowNumber}: Format tanggal tidak valid. Gunakan YYYY-MM-DD.";
                    continue;
                }

                // Auto-generate no_batch if empty
                $noBatch = $data['no_batch'];
                if (empty($noBatch)) {
                    $noBatch = 'BATCH-' . strtoupper(Str::random(6));
                }

                $jumlah = (int) $data['jumlah'];
                $hargaBeli = (float) str_replace([',', '.'], ['', ''], $data['harga_beli']);
                $hargaJual = (float) str_replace([',', '.'], ['', ''], $data['harga_jual']);

                // If harga_jual is 0, calculate with 50% markup
                if ($hargaJual <= 0 && $hargaBeli > 0) {
                    $hargaJual = $hargaBeli * 1.5;
                }

                // Create stok_batch
                StokBatch::create([
                    'uuid' => Str::uuid(),
                    'obat_id' => $obat->id,
                    'pembelian_id' => null, // No purchase reference for initial stock
                    'no_batch' => $noBatch,
                    'barcode' => $obat->barcode,
                    'harga_beli' => $hargaBeli,
                    'harga_jual' => $hargaJual,
                    'jumlah_masuk' => $jumlah,
                    'sisa_stok' => $jumlah,
                    'tgl_kadaluarsa' => $tglKadaluarsa,
                ]);

                $imported++;
            }

            fclose($handle);

            if ($imported > 0) {
                DB::commit();
                $message = "Berhasil mengimport {$imported} data stok.";
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