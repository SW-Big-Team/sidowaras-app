<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obat;
use App\Models\StokBatch;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StokBatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obats = Obat::all();

        foreach ($obats as $obat) {
            $batchCount = rand(2, 3);
            
            for ($i = 0; $i < $batchCount; $i++) {
                $hargaBeli = rand(5000, 50000);
                $marginProfit = rand(20, 40); 
                $hargaJual = $hargaBeli + ($hargaBeli * $marginProfit / 100);
                
                $jumlahMasuk = rand(50, 200);
                $sisaStok = rand(10, $jumlahMasuk); 
                
                $tglKadaluarsa = Carbon::now()->addMonths(rand(12, 36))->format('Y-m-d');
                
                StokBatch::create([
                    'uuid' => (string) Str::uuid(),
                    'obat_id' => $obat->id,
                    'pembelian_id' => null, 
                    'no_batch' => 'BATCH-' . strtoupper(Str::random(8)),
                    'barcode' => $obat->barcode,
                    'harga_beli' => $hargaBeli,
                    'harga_jual' => round($hargaJual, -2), 
                    'jumlah_masuk' => $jumlahMasuk,
                    'sisa_stok' => $sisaStok,
                    'tgl_kadaluarsa' => $tglKadaluarsa,
                ]);
            }
        }
    }
}
