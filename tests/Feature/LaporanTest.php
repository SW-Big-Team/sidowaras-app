<?php

use App\Http\Middleware\EnsureSingleSession;
use App\Models\DetailTransaksi;
use App\Models\KategoriObat;
use App\Models\Obat;
use App\Models\Pembelian;
use App\Models\Role;
use App\Models\SatuanObat;
use App\Models\StokBatch;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->withoutMiddleware(EnsureSingleSession::class);
    // Create roles
    Role::firstOrCreate(['nama_role' => 'Admin'], ['uuid' => Str::uuid()]);
    Role::firstOrCreate(['nama_role' => 'Karyawan'], ['uuid' => Str::uuid()]);
    Role::firstOrCreate(['nama_role' => 'Kasir'], ['uuid' => Str::uuid()]);
});

// ========== TEST 1: Access Control ==========

test('admin dapat akses halaman laporan', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $response = $this->actingAs($admin)->get('/adminx/laporan');
    
    $response->assertStatus(200);
    $response->assertViewIs('admin.laporan.index');
});

test('karyawan tidak dapat akses laporan', function () {
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    $response = $this->actingAs($karyawan)->get('/adminx/laporan');
    
    $response->assertStatus(403);
});

// ========== TEST 2: Revenue Calculation ==========

test('laporan menampilkan total revenue dari periode tertentu', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    // Create transaksi
    $transaksi1 = Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-001',
        'user_id' => $kasir->id,
        'total_harga' => 100000,
        'total_bayar' => 100000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now()->startOfMonth(),
    ]);
    
    $transaksi2 = Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-002',
        'user_id' => $kasir->id,
        'total_harga' => 50000,
        'total_bayar' => 50000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    $response = $this->actingAs($admin)->get('/adminx/laporan');
    
    $response->assertStatus(200);
    $response->assertViewHas('totalRevenue', 150000);
});

test('laporan menghitung perubahan revenue dibanding periode sebelumnya', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    // Previous period: 100000
    Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-001',
        'user_id' => $kasir->id,
        'total_harga' => 100000,
        'total_bayar' => 100000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now()->subMonths(2),
    ]);
    
    // Current period: 200000 (100% increase)
    Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-002',
        'user_id' => $kasir->id,
        'total_harga' => 200000,
        'total_bayar' => 200000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    $response = $this->actingAs($admin)->get('/adminx/laporan');
    
    $response->assertStatus(200);
    $response->assertViewHas('revenueChange');
});

// ========== TEST 3: Transaction Count ==========

test('laporan menampilkan jumlah transaksi dalam periode', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    // Create 3 transaksi
    for ($i = 1; $i <= 3; $i++) {
        Transaksi::create([
            'uuid' => Str::uuid(),
            'no_transaksi' => "TRX-00{$i}",
            'user_id' => $kasir->id,
            'total_harga' => 50000,
            'total_bayar' => 50000,
            'kembalian' => 0,
            'metode_pembayaran' => 'tunai',
            'tgl_transaksi' => now(),
        ]);
    }
    
    $response = $this->actingAs($admin)->get('/adminx/laporan');
    
    $response->assertStatus(200);
    $response->assertViewHas('totalTransactions', 3);
});

// ========== TEST 4: Payment Method Distribution ==========

test('laporan menampilkan distribusi metode pembayaran', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    // 2 tunai, 1 non-tunai
    for ($i = 1; $i <= 2; $i++) {
        Transaksi::create([
            'uuid' => Str::uuid(),
            'no_transaksi' => "TRX-00{$i}",
            'user_id' => $kasir->id,
            'total_harga' => 50000,
            'total_bayar' => 50000,
            'kembalian' => 0,
            'metode_pembayaran' => 'tunai',
            'tgl_transaksi' => now(),
        ]);
    }
    
    Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-003',
        'user_id' => $kasir->id,
        'total_harga' => 75000,
        'total_bayar' => 75000,
        'kembalian' => 0,
        'metode_pembayaran' => 'non tunai',
        'tgl_transaksi' => now(),
    ]);
    
    $response = $this->actingAs($admin)->get('/adminx/laporan');
    
    $response->assertStatus(200);
    $response->assertViewHas('tunaiPercentage');
    $response->assertViewHas('nonTunaiPercentage');
});

// ========== TEST 5: Top Selling Medicines ==========

test('laporan menampilkan obat terlaris', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    // Create test obat and batches
    $obat1 = createLaporanTestData(1, 100);
    $batch1 = $obat1->stokBatches()->first();
    
    $obat2 = createLaporanTestData(1, 50);
    $batch2 = $obat2->stokBatches()->first();
    
    // Create transaksi
    $transaksi = Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-001',
        'user_id' => $kasir->id,
        'total_harga' => 140000,
        'total_bayar' => 140000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    // Detail transaksi: obat1 = 10 unit, obat2 = 5 unit
    DetailTransaksi::create([
        'uuid' => Str::uuid(),
        'transaksi_id' => $transaksi->id,
        'batch_id' => $batch1->id,
        'jumlah' => 10,
        'harga_saat_transaksi' => 7000,
        'sub_total' => 70000,
    ]);
    
    DetailTransaksi::create([
        'uuid' => Str::uuid(),
        'transaksi_id' => $transaksi->id,
        'batch_id' => $batch2->id,
        'jumlah' => 5,
        'harga_saat_transaksi' => 14000,
        'sub_total' => 70000,
    ]);
    
    $response = $this->actingAs($admin)->get('/adminx/laporan');
    
    $response->assertStatus(200);
    $response->assertViewHas('topSelling');
});

// ========== TEST 6: Low Stock Alerts ==========

test('laporan menampilkan obat dengan stok rendah', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    // Create obat with low stock
    $kategori = KategoriObat::firstOrCreate(
        ['nama_kategori' => 'Test Kategori'],
        ['uuid' => Str::uuid()]
    );
    
    $satuan = SatuanObat::firstOrCreate(
        ['nama_satuan' => 'Test Satuan'],
        ['uuid' => Str::uuid(), 'faktor_konversi' => 1]
    );
    
    $obat = Obat::create([
        'uuid' => Str::uuid(),
        'nama_obat' => 'Test Obat Low Stock',
        'kode_obat' => 'OBAT-LOW',
        'kategori_id' => $kategori->id,
        'satuan_obat_id' => $satuan->id,
        'stok_minimum' => 50, // Minimum is 50
        'is_racikan' => false,
        'lokasi_rak' => 'A-01',
        'barcode' => strtoupper(Str::random(13)),
    ]);
    
    // Only 5 items in stock (below minimum)
    StokBatch::create([
        'obat_id' => $obat->id,
        'no_batch' => 'BATCH-LOW',
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'jumlah_masuk' => 5,
        'sisa_stok' => 5,
        'tgl_kadaluarsa' => now()->addYear(),
    ]);
    
    $response = $this->actingAs($admin)->get('/adminx/laporan');
    
    $response->assertStatus(200);
    $response->assertViewHas('lowStock');
});

// ========== TEST 7: Purchase Data ==========

test('laporan dapat di-filter dengan date range custom', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $from = now()->subDays(7)->format('Y-m-d');
    $to = now()->format('Y-m-d');
    
    // Create transaksi dalam range
    Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-001',
        'user_id' => $kasir->id,
        'total_harga' => 100000,
        'total_bayar' => 100000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    $response = $this->actingAs($admin)->get("/adminx/laporan?from={$from}&to={$to}");
    
    $response->assertStatus(200);
    $response->assertViewHas('from');
    $response->assertViewHas('to');
});

// ========== TEST 8: Chart Data ==========

test('laporan menyediakan data untuk chart', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    // Create transaksi untuk chart data
    for ($i = 0; $i < 5; $i++) {
        Transaksi::create([
            'uuid' => Str::uuid(),
            'no_transaksi' => "TRX-{$i}",
            'user_id' => $kasir->id,
            'total_harga' => 50000,
            'total_bayar' => 50000,
            'kembalian' => 0,
            'metode_pembayaran' => 'tunai',
            'tgl_transaksi' => now()->subDays($i),
        ]);
    }
    
    $response = $this->actingAs($admin)->get('/adminx/laporan');
    
    $response->assertStatus(200);
    $response->assertViewHas('monthlyData');
    $response->assertViewHas('monthlyLabels');
});

// ========== TEST 10: Stock Count ==========

test('laporan menampilkan total stok semua obat', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    // Create obat dengan stok
    $obat = createLaporanTestData(1, 100);
    
    $response = $this->actingAs($admin)->get('/adminx/laporan');
    
    $response->assertStatus(200);
    $response->assertViewHas('totalStock');
});

// ========== TEST 11: Default Date Range ==========

test('laporan menggunakan bulan ini sebagai default date range', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $response = $this->actingAs($admin)->get('/adminx/laporan');
    
    $response->assertStatus(200);
    // Should have from and to dates
    $response->assertViewHas('from');
    $response->assertViewHas('to');
});

// ========== TEST 12: Negative Cases ==========

test('laporan menolak akses dari user yang tidak authenticated', function () {
    $response = $this->get('/adminx/laporan');
    
    $response->assertStatus(302);
    $response->assertRedirect('/login');
});

test('laporan menolak akses dari user dengan role karyawan', function () {
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    $response = $this->actingAs($karyawan)->get('/adminx/laporan');
    
    $response->assertStatus(403);
});

// ========== Helper Functions ==========

function createLaporanTestData($count = 1, $initialStock = 50): Obat
{
    $kategori = KategoriObat::firstOrCreate(
        ['nama_kategori' => 'Test Kategori'],
        ['uuid' => Str::uuid()]
    );
    
    $satuan = SatuanObat::firstOrCreate(
        ['nama_satuan' => 'Test Satuan'],
        ['uuid' => Str::uuid(), 'faktor_konversi' => 1]
    );
    
    $obat = Obat::create([
        'uuid' => Str::uuid(),
        'nama_obat' => 'Test Obat ' . Str::random(6),
        'kode_obat' => 'OBAT-' . strtoupper(Str::random(6)),
        'kategori_id' => $kategori->id,
        'satuan_obat_id' => $satuan->id,
        'stok_minimum' => 10,
        'is_racikan' => false,
        'lokasi_rak' => 'A-01',
        'barcode' => strtoupper(Str::random(13)),
        'deskripsi' => 'Test obat untuk laporan',
    ]);
    
    StokBatch::create([
        'obat_id' => $obat->id,
        'no_batch' => 'BATCH-' . strtoupper(Str::random(6)),
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'jumlah_masuk' => $initialStock,
        'sisa_stok' => $initialStock,
        'tgl_kadaluarsa' => now()->addYear(),
        'pembelian_id' => null,
    ]);
    
    return $obat;
}
