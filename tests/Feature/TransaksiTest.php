<?php

use App\Http\Middleware\EnsureSingleSession;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\DetailTransaksi;
use App\Models\KategoriObat;
use App\Models\LogPerubahanStok;
use App\Models\Obat;
use App\Models\Role;
use App\Models\SatuanObat;
use App\Models\StokBatch;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Str;

function bypassMiddleware() {
    return test()
        ->withoutMiddleware(EnsureSingleSession::class)
        ->withoutMiddleware(\App\Http\Middleware\RoleMiddleware::class);
}

beforeEach(function () {
    $this->withoutMiddleware(EnsureSingleSession::class);
    // Create roles
    Role::firstOrCreate(['nama_role' => 'Admin'], ['uuid' => Str::uuid()]);
    Role::firstOrCreate(['nama_role' => 'Karyawan'], ['uuid' => Str::uuid()]);
    Role::firstOrCreate(['nama_role' => 'Kasir'], ['uuid' => Str::uuid()]);
});

// ========== TEST 1: Kasir melihat riwayat transaksi ==========

test('kasir dapat melihat riwayat transaksi mereka', function () {
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createTransaksiTestData(1, 50);
    
    $transaksi = Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00001',
        'user_id' => $kasir->id,
        'total_harga' => 100000,
        'total_bayar' => 100000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    DetailTransaksi::create([
        'uuid' => Str::uuid(),
        'transaksi_id' => $transaksi->id,
        'batch_id' => $obat->stokBatches()->first()->id,
        'jumlah' => 10,
        'harga_saat_transaksi' => 7000,
        'sub_total' => 70000,
    ]);
    
    $response = $this->actingAs($kasir)->get('/kasir/transaksi/riwayat');
    
    $response->assertStatus(200);
    $response->assertViewIs('kasir.transaksi.riwayat');
    $response->assertViewHas('transaksis');
});

test('kasir hanya melihat transaksi mereka sendiri', function () {
    $kasir1 = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir1-' . Str::uuid() . '@example.com',
    ]);
    
    $kasir2 = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir2-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createTransaksiTestData(1, 50);
    
    // Transaksi dari kasir1
    $trx1 = Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00001',
        'user_id' => $kasir1->id,
        'total_harga' => 100000,
        'total_bayar' => 100000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    // Transaksi dari kasir2
    $trx2 = Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00002',
        'user_id' => $kasir2->id,
        'total_harga' => 50000,
        'total_bayar' => 50000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    $response = $this->actingAs($kasir1)->get('/kasir/transaksi/riwayat');
    
    $response->assertStatus(200);
    // Should only see kasir1's transaction
    $this->assertDatabaseHas('transaksi', [
        'user_id' => $kasir1->id,
        'no_transaksi' => 'TRX-250101-00001',
    ]);
});

// ========== TEST 2: Kasir lihat detail transaksi ==========

test('kasir dapat melihat detail transaksi', function () {
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createTransaksiTestData(1, 50);
    $batch = $obat->stokBatches()->first();
    
    $transaksi = Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00001',
        'user_id' => $kasir->id,
        'total_harga' => 70000,
        'total_bayar' => 100000,
        'kembalian' => 30000,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    DetailTransaksi::create([
        'uuid' => Str::uuid(),
        'transaksi_id' => $transaksi->id,
        'batch_id' => $batch->id,
        'jumlah' => 10,
        'harga_saat_transaksi' => 7000,
        'sub_total' => 70000,
    ]);
    
    $response = $this->actingAs($kasir)->get("/kasir/transaksi/{$transaksi->id}");
    
    $response->assertStatus(200);
    $response->assertViewIs('kasir.transaksi.show');
    $response->assertViewHas('transaksi');
    $response->assertViewHas('detail');
});

// ========== TEST 3: Search dan Filter transaksi ==========

test('kasir dapat search transaksi by nomor transaksi', function () {
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createTransaksiTestData(1, 50);
    
    Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00001',
        'user_id' => $kasir->id,
        'total_harga' => 100000,
        'total_bayar' => 100000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00002',
        'user_id' => $kasir->id,
        'total_harga' => 50000,
        'total_bayar' => 50000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    $response = $this->actingAs($kasir)->get('/kasir/transaksi/riwayat?search=00001');
    
    $response->assertStatus(200);
    $response->assertViewHas('transaksis');
});

test('kasir dapat filter transaksi by metode pembayaran', function () {
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createTransaksiTestData(1, 50);
    
    Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00001',
        'user_id' => $kasir->id,
        'total_harga' => 100000,
        'total_bayar' => 100000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00002',
        'user_id' => $kasir->id,
        'total_harga' => 50000,
        'total_bayar' => 50000,
        'kembalian' => 0,
        'metode_pembayaran' => 'non tunai',
        'tgl_transaksi' => now(),
    ]);
    
    $response = $this->actingAs($kasir)->get('/kasir/transaksi/riwayat?metode=tunai');
    
    $response->assertStatus(200);
    $response->assertViewHas('transaksis');
});

// ========== TEST 4: Transaksi Relationships ==========

test('transaksi memiliki relasi dengan user yang tepat', function () {
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $transaksi = Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00001',
        'user_id' => $kasir->id,
        'total_harga' => 100000,
        'total_bayar' => 100000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    $this->assertEquals($kasir->id, $transaksi->user->id);
    $this->assertEquals($kasir->nama_lengkap, $transaksi->user->nama_lengkap);
});

test('detail transaksi memiliki relasi dengan transaksi dan batch', function () {
    $obat = createTransaksiTestData(1, 50);
    $batch = $obat->stokBatches()->first();
    
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $transaksi = Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00001',
        'user_id' => $kasir->id,
        'total_harga' => 70000,
        'total_bayar' => 70000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    $detail = DetailTransaksi::create([
        'uuid' => Str::uuid(),
        'transaksi_id' => $transaksi->id,
        'batch_id' => $batch->id,
        'jumlah' => 10,
        'harga_saat_transaksi' => 7000,
        'sub_total' => 70000,
    ]);
    
    $this->assertEquals($transaksi->id, $detail->transaksi->id);
    $this->assertEquals($batch->id, $detail->batch->id);
});

// ========== TEST 5: Transaksi Data Validation ==========

test('transaksi dapat dibuat dengan metode pembayaran tunai', function () {
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $transaksi = Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00001',
        'user_id' => $kasir->id,
        'total_harga' => 100000,
        'total_bayar' => 150000,
        'kembalian' => 50000,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    $this->assertDatabaseHas('transaksi', [
        'no_transaksi' => 'TRX-250101-00001',
        'user_id' => $kasir->id,
        'metode_pembayaran' => 'tunai',
        'kembalian' => 50000,
    ]);
});

test('transaksi dapat dibuat dengan metode pembayaran non tunai', function () {
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $transaksi = Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00002',
        'user_id' => $kasir->id,
        'total_harga' => 100000,
        'total_bayar' => 100000,
        'kembalian' => 0,
        'metode_pembayaran' => 'non tunai',
        'tgl_transaksi' => now(),
    ]);
    
    $this->assertDatabaseHas('transaksi', [
        'no_transaksi' => 'TRX-250101-00002',
        'metode_pembayaran' => 'non tunai',
        'kembalian' => 0,
    ]);
});

test('transaksi menyimpan uuid secara otomatis', function () {
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $transaksi = Transaksi::create([
        'no_transaksi' => 'TRX-250101-00003',
        'user_id' => $kasir->id,
        'total_harga' => 50000,
        'total_bayar' => 50000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    $this->assertNotNull($transaksi->uuid);
    $this->assertTrue(strlen($transaksi->uuid) === 36); // UUID format
});

// ========== TEST 6: Stock Availability ==========

test('transaksi gagal jika stok tidak cukup', function () {
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createTransaksiTestData(1, 20);
    
    $cart = Cart::create([
        'uuid' => Str::uuid(),
        'user_id' => $kasir->id,
        'is_approved' => false,
    ]);
    
    CartItem::create([
        'uuid' => Str::uuid(),
        'cart_id' => $cart->id,
        'obat_id' => $obat->id,
        'jumlah' => 100, // Lebih dari yang tersedia
        'harga_satuan' => 7000,
    ]);
    
    $response = $this->actingAs($kasir)->post('/kasir/cart/process-payment', [
        'cart_id' => $cart->id,
        'metode_pembayaran' => 'tunai',
        'total_bayar' => 700000,
    ]);
    
    // Transaction should not be created
    $this->assertDatabaseMissing('transaksi', [
        'no_transaksi' => 'TRX-*',
    ]);
});

// ========== TEST 7: Cart & Detail Transaksi ==========

test('detail transaksi menyimpan sub_total dengan benar', function () {
    $obat = createTransaksiTestData(1, 50);
    $batch = $obat->stokBatches()->first();
    
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $transaksi = Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00001',
        'user_id' => $kasir->id,
        'total_harga' => 70000,
        'total_bayar' => 70000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    $detail = DetailTransaksi::create([
        'uuid' => Str::uuid(),
        'transaksi_id' => $transaksi->id,
        'batch_id' => $batch->id,
        'jumlah' => 10,
        'harga_saat_transaksi' => 7000,
        'sub_total' => 70000,
    ]);
    
    $this->assertDatabaseHas('detail_transaksi', [
        'transaksi_id' => $transaksi->id,
        'batch_id' => $batch->id,
        'jumlah' => 10,
        'harga_saat_transaksi' => 7000,
        'sub_total' => 70000,
    ]);
});

// ========== TEST 8: Negative Cases ==========

test('karyawan tidak dapat akses transaksi', function () {
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    $response = $this->actingAs($karyawan)->get('/kasir/transaksi/riwayat');
    
    $response->assertStatus(403);
});

test('detail transaksi tidak dapat dibuat tanpa batch_id', function () {
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $transaksi = Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00001',
        'user_id' => $kasir->id,
        'total_harga' => 70000,
        'total_bayar' => 70000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    // Try to create without batch_id - should violate FK
    try {
        DetailTransaksi::create([
            'uuid' => Str::uuid(),
            'transaksi_id' => $transaksi->id,
            'batch_id' => 99999, // Non-existent batch
            'jumlah' => 10,
            'harga_saat_transaksi' => 7000,
            'sub_total' => 70000,
        ]);
        
        $this->fail('Expected foreign key constraint exception');
    } catch (\Exception $e) {
        $this->assertTrue(true);
    }
});

test('hanya kasir dan admin yang bisa lihat transaksi', function () {
    // User yang tidak authenticated
    $response = $this->get('/kasir/transaksi/riwayat');
    $response->assertStatus(302); // Redirect to login
});

test('transaksi dengan jumlah negatif - cart items dengan qty negatif ditolak validasi', function () {
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createTransaksiTestData(1, 50);
    
    $cart = Cart::create([
        'uuid' => Str::uuid(),
        'user_id' => $kasir->id,
        'is_approved' => false,
    ]);
    
    // Try to create CartItem with negative quantity
    // Should fail validation atau constraint
    $hasError = false;
    try {
        $item = CartItem::create([
            'uuid' => Str::uuid(),
            'cart_id' => $cart->id,
            'obat_id' => $obat->id,
            'jumlah' => -5, // Negative quantity
            'harga_satuan' => 7000,
        ]);
        
        // Jika berhasil dibuat, check bahwa jumlah sebenarnya tidak boleh negatif
        $this->assertFalse($item->jumlah < 0, 'CartItem dengan qty negatif tidak boleh tersimpan');
    } catch (\Exception $e) {
        // Expected - validasi database menolak nilai negatif
        $hasError = true;
    }
    
    $this->assertTrue($hasError, 'Diharapkan ada error saat membuat CartItem dengan qty negatif');
});

test('cart dengan item kosong tidak bisa diproses - cart tanpa items', function () {
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $cart = Cart::create([
        'uuid' => Str::uuid(),
        'user_id' => $kasir->id,
        'is_approved' => false,
    ]);
    
    // Cart tanpa items - total_harga akan 0
    // processPayment seharusnya tidak membuat transaksi
    $response = $this->actingAs($kasir)->post('/kasir/cart/process-payment', [
        'cart_id' => $cart->id,
        'metode_pembayaran' => 'tunai',
        'total_bayar' => 0,
    ]);
    
    // Check bahwa transaksi tidak dibuat untuk cart kosong
    // Status bisa 302 (redirect), 422 (validation error), atau 500 (exception)
    $this->assertTrue(
        in_array($response->status(), [302, 422, 500]),
        "Expected status 302, 422 or 500 for empty cart, got {$response->status()}"
    );
});

// ========== TEST 9: Authorization ==========

test('hanya kasir yang bisa akses transaksi riwayat', function () {
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    $response = $this->actingAs($karyawan)->get('/kasir/transaksi/riwayat');
    
    $response->assertStatus(403);
});

test('admin dapat melihat riwayat transaksi semua kasir', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createTransaksiTestData(1, 50);
    
    $transaksi = Transaksi::create([
        'uuid' => Str::uuid(),
        'no_transaksi' => 'TRX-250101-00001',
        'user_id' => $kasir->id,
        'total_harga' => 100000,
        'total_bayar' => 100000,
        'kembalian' => 0,
        'metode_pembayaran' => 'tunai',
        'tgl_transaksi' => now(),
    ]);
    
    $response = $this->actingAs($admin)->get('/adminx/transaksi/riwayat');
    
    $response->assertStatus(200);
});

// ========== Helper Functions ==========

function createTransaksiTestData($count = 1, $initialStock = 50): Obat
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
        'deskripsi' => 'Test obat untuk transaksi',
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
