<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obat;
use App\Models\KategoriObat;
use App\Models\SatuanObat;
use App\Models\KandunganObat;
use Illuminate\Support\Str;

class ObatSeeder extends Seeder
{
    /**
     * Generate EAN-13 barcode
     * Format: 12 digit + 1 check digit
     */
    private function generateEAN13()
    {
        // Generate 12 random digits
        $code = '';
        for ($i = 0; $i < 12; $i++) {
            $code .= rand(0, 9);
        }
        
        // Calculate check digit
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $digit = (int) $code[$i];
            // Multiply odd positions by 1, even positions by 3
            $sum += ($i % 2 === 0) ? $digit : $digit * 3;
        }
        
        $checkDigit = (10 - ($sum % 10)) % 10;
        
        return $code . $checkDigit;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil referensi kategori
        $obatKeras = KategoriObat::where('nama_kategori', 'Obat Keras')->first();
        $obatBebas = KategoriObat::where('nama_kategori', 'Obat Bebas')->first();
        $obatBebasTerbatas = KategoriObat::where('nama_kategori', 'Obat Bebas Terbatas')->first();
        $herbal = KategoriObat::where('nama_kategori', 'Herbal')->first();
        $alatKesehatan = KategoriObat::where('nama_kategori', 'Alat Kesehatan')->first();

        // Ambil referensi satuan
        $tablet = SatuanObat::where('nama_satuan', 'Tablet')->first();
        $kapsul = SatuanObat::where('nama_satuan', 'Kapsul')->first();
        $strip = SatuanObat::where('nama_satuan', 'Strip')->first();
        $botol = SatuanObat::where('nama_satuan', 'Botol')->first();
        $box = SatuanObat::where('nama_satuan', 'Box')->first();
        $tube = SatuanObat::where('nama_satuan', 'Tube')->first();
        $pcs = SatuanObat::where('nama_satuan', 'Pcs')->first();

        // Ambil referensi kandungan - nama_kandungan is JSON array, use JSON query
        $paracetamol = KandunganObat::whereJsonContains('nama_kandungan', 'Paracetamol')->first();
        $ibuprofen = KandunganObat::whereJsonContains('nama_kandungan', 'Ibuprofen')->first();
        $amoxicillin = KandunganObat::whereJsonContains('nama_kandungan', 'Amoxicillin')->first();
        $cetirizine = KandunganObat::whereJsonContains('nama_kandungan', 'Cetirizine')->first();
        $loratadine = KandunganObat::whereJsonContains('nama_kandungan', 'Loratadine')->first();

        $obatData = [
            [
                'kode_obat' => 'OBT-001',
                'nama_obat' => 'Panadol',
                'deskripsi' => 'Merk dagang obat pereda nyeri dan penurun demam',
                'kategori_id' => $obatBebas?->id,
                'satuan_obat_id' => $tablet?->id,
                'kandungan_id' => $paracetamol ? [$paracetamol->id] : null,
                'stok_minimum' => 50,
                'is_racikan' => false,
                'lokasi_rak' => 'A-01',
                'barcode' => $this->generateEAN13(),
            ],
            [
                'kode_obat' => 'OBT-002',
                'nama_obat' => 'Biogesic',
                'deskripsi' => 'Merk dagang obat pereda nyeri dengan kandungan paracetamol',
                'kategori_id' => $obatBebas?->id,
                'satuan_obat_id' => $tablet?->id,
                'kandungan_id' => $paracetamol ? [$paracetamol->id] : null,
                'stok_minimum' => 45,
                'is_racikan' => false,
                'lokasi_rak' => 'A-02',
                'barcode' => $this->generateEAN13(),
            ],
            [
                'kode_obat' => 'OBT-003',
                'nama_obat' => 'Proris',
                'deskripsi' => 'Merk dagang anti-inflamasi untuk nyeri dan demam',
                'kategori_id' => $obatBebasTerbatas?->id,
                'satuan_obat_id' => $tablet?->id,
                'kandungan_id' => $ibuprofen ? [$ibuprofen->id] : null,
                'stok_minimum' => 40,
                'is_racikan' => false,
                'lokasi_rak' => 'A-03',
                'barcode' => $this->generateEAN13(),
            ],
            [
                'kode_obat' => 'OBT-004',
                'nama_obat' => 'Amoxsan',
                'deskripsi' => 'Merk dagang antibiotik untuk infeksi bakteri',
                'kategori_id' => $obatKeras?->id,
                'satuan_obat_id' => $kapsul?->id,
                'kandungan_id' => $amoxicillin ? [$amoxicillin->id] : null,
                'stok_minimum' => 30,
                'is_racikan' => false,
                'lokasi_rak' => 'B-01',
                'barcode' => $this->generateEAN13(),
            ],
            [
                'kode_obat' => 'OBT-005',
                'nama_obat' => 'Incidal OD',
                'deskripsi' => 'Merk dagang antihistamin untuk alergi',
                'kategori_id' => $obatBebas?->id,
                'satuan_obat_id' => $tablet?->id,
                'kandungan_id' => $cetirizine ? [$cetirizine->id] : null,
                'stok_minimum' => 35,
                'is_racikan' => false,
                'lokasi_rak' => 'A-04',
                'barcode' => $this->generateEAN13(),
            ],
            [
                'kode_obat' => 'OBT-006',
                'nama_obat' => 'Allerta',
                'deskripsi' => 'Merk dagang antihistamin untuk rhinitis alergi',
                'kategori_id' => $obatBebas?->id,
                'satuan_obat_id' => $tablet?->id,
                'kandungan_id' => $loratadine ? [$loratadine->id] : null,
                'stok_minimum' => 30,
                'is_racikan' => false,
                'lokasi_rak' => 'A-05',
                'barcode' => $this->generateEAN13(),
            ],
            [
                'kode_obat' => 'OBT-007',
                'nama_obat' => 'Tolak Angin',
                'deskripsi' => 'Obat herbal untuk masuk angin',
                'kategori_id' => $herbal?->id,
                'satuan_obat_id' => $botol?->id,
                'kandungan_id' => null,
                'stok_minimum' => 20,
                'is_racikan' => false,
                'lokasi_rak' => 'C-01',
                'barcode' => $this->generateEAN13(),
            ],
            [
                'kode_obat' => 'OBT-008',
                'nama_obat' => 'Sensi Masker 3 Ply',
                'deskripsi' => 'Masker medis sekali pakai merk Sensi',
                'kategori_id' => $alatKesehatan?->id,
                'satuan_obat_id' => $box?->id,
                'kandungan_id' => null,
                'stok_minimum' => 100,
                'is_racikan' => false,
                'lokasi_rak' => 'D-01',
                'barcode' => $this->generateEAN13(),
            ],
            [
                'kode_obat' => 'OBT-009',
                'nama_obat' => 'Betadine Salep',
                'deskripsi' => 'Salep antiseptik untuk luka luar',
                'kategori_id' => $obatBebasTerbatas?->id,
                'satuan_obat_id' => $tube?->id,
                'kandungan_id' => null,
                'stok_minimum' => 25,
                'is_racikan' => false,
                'lokasi_rak' => 'B-02',
                'barcode' => $this->generateEAN13(),
            ],
        ];

        foreach ($obatData as $data) {
            $obat = Obat::updateOrCreate(
                [
                    'kode_obat' => $data['kode_obat'],
                ],
                [
                    'nama_obat' => $data['nama_obat'],
                    'deskripsi' => $data['deskripsi'],
                    'kategori_id' => $data['kategori_id'],
                    'satuan_obat_id' => $data['satuan_obat_id'],
                    'kandungan_id' => $data['kandungan_id'], // Already an array, will be auto-cast to JSON
                    'stok_minimum' => $data['stok_minimum'],
                    'is_racikan' => $data['is_racikan'],
                    'lokasi_rak' => $data['lokasi_rak'],
                    'barcode' => $data['barcode'],
                ]
            );
            
            // Ensure UUID is set if not already present
            if (empty($obat->uuid)) {
                $obat->uuid = Str::uuid();
                $obat->save();
            }
        }
    }
}
