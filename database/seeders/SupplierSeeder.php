<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'supplier_name' => 'PT. Kimia Farma Trading & Distribution',
                'supplier_address' => 'Jl. Budi Utomo No. 1, Jakarta Pusat',
                'supplier_phone' => '021-3847777',
            ],
            [
                'supplier_name' => 'PT. Anugrah Argon Medica',
                'supplier_address' => 'Titan Center, Jl. Boulevard Bintaro Jaya, Tangerang Selatan',
                'supplier_phone' => '021-7454222',
            ],
            [
                'supplier_name' => 'PT. Mensa Bina Sukses',
                'supplier_address' => 'Jl. Pulo Kambing II No. 26, Jakarta Timur',
                'supplier_phone' => '021-4608888',
            ],
            [
                'supplier_name' => 'PT. Bina San Prima',
                'supplier_address' => 'Jl. Rawa Gelam IV No. 1, Jakarta Timur',
                'supplier_phone' => '021-4605555',
            ],
            [
                'supplier_name' => 'PT. Enseval Putera Megatrading',
                'supplier_address' => 'Jl. Pulo Lentut No. 10, Jakarta Timur',
                'supplier_phone' => '021-4609999',
            ],
        ];

        foreach ($suppliers as $supplier) {
            \App\Models\Supplier::create($supplier);
        }
    }
}
