<?php

use App\Models\Notifikasi;
use App\Models\Obat;
use App\Models\KategoriObat;
use App\Models\SatuanObat;
use App\Models\StokBatch;
use App\Models\Role;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Str;

beforeEach(function () {
    // Create roles
    Role::firstOrCreate(['nama_role' => 'Admin'], ['uuid' => Str::uuid()]);
    Role::firstOrCreate(['nama_role' => 'Karyawan'], ['uuid' => Str::uuid()]);
    Role::firstOrCreate(['nama_role' => 'Kasir'], ['uuid' => Str::uuid()]);
});

// ========== TEST 1: Stok Menipis (< stok_minimum) ==========

test('notifikasi muncul ketika stok obat kurang dari minimum', function () {
    // Create obat dengan stok_minimum = 50
    $obat = createTestObat(['stok_minimum' => 50]);
    
    // Create batch dengan stok 30 (lebih kecil dari minimum 50)
    StokBatch::create([
        'obat_id' => $obat->id,
        'no_batch' => 'BATCH-001',
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'jumlah_masuk' => 30,
        'sisa_stok' => 30, // Stok kurang dari minimum
        'tgl_kadaluarsa' => now()->addYear(),
        'pembelian_id' => null,
    ]);
    
    $service = new NotificationService();
    $service->checkStokMenipis();
    
    // Verify notification created untuk Admin
    $this->assertDatabaseHas('notifikasi', [
        'type' => 'stok_menipis',
        'role' => 'Admin',
        'is_warning' => true,
    ]);
    
    // Verify notification created untuk Karyawan
    $this->assertDatabaseHas('notifikasi', [
        'type' => 'stok_menipis',
        'role' => 'Karyawan',
        'is_warning' => true,
    ]);
});

test('notifikasi tidak muncul ketika stok obat normal', function () {
    // Create obat dengan stok_minimum = 50
    $obat = createTestObat(['stok_minimum' => 50]);
    
    // Create batch dengan stok 100 (lebih besar dari minimum 50)
    StokBatch::create([
        'obat_id' => $obat->id,
        'no_batch' => 'BATCH-002',
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'jumlah_masuk' => 100,
        'sisa_stok' => 100, // Stok normal
        'tgl_kadaluarsa' => now()->addYear(),
        'pembelian_id' => null,
    ]);
    
    $service = new NotificationService();
    $service->checkStokMenipis();
    
    // Verify no notification for stok_menipis
    $this->assertDatabaseMissing('notifikasi', [
        'type' => 'stok_menipis',
        'role' => 'Admin',
    ]);
    
    $this->assertDatabaseMissing('notifikasi', [
        'type' => 'stok_menipis',
        'role' => 'Karyawan',
    ]);
});

// ========== TEST 2: Obat Kadaluarsa (< 30 hari) ==========

test('notifikasi muncul ketika obat akan kadaluarsa dalam 30 hari', function () {
    $obat = createTestObat();
    
    // Create batch dengan expiry date dalam 20 hari (< 30 hari)
    StokBatch::create([
        'obat_id' => $obat->id,
        'no_batch' => 'BATCH-EXPIRE-001',
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'jumlah_masuk' => 100,
        'sisa_stok' => 100,
        'tgl_kadaluarsa' => now()->addDays(20),
        'pembelian_id' => null,
    ]);
    
    $service = new NotificationService();
    $service->checkObatKadaluarsa();
    
    // Verify notification created untuk Admin
    $this->assertDatabaseHas('notifikasi', [
        'type' => 'obat_kadaluarsa',
        'role' => 'Admin',
        'is_warning' => true,
    ]);
    
    // Verify notification created untuk Karyawan
    $this->assertDatabaseHas('notifikasi', [
        'type' => 'obat_kadaluarsa',
        'role' => 'Karyawan',
        'is_warning' => true,
    ]);
});

test('notifikasi tidak muncul ketika obat masih jauh dari kadaluarsa', function () {
    $obat = createTestObat();
    
    // Create batch dengan expiry date dalam 60 hari (> 30 hari)
    StokBatch::create([
        'obat_id' => $obat->id,
        'no_batch' => 'BATCH-EXPIRE-002',
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'jumlah_masuk' => 100,
        'sisa_stok' => 100,
        'tgl_kadaluarsa' => now()->addDays(60),
        'pembelian_id' => null,
    ]);
    
    $service = new NotificationService();
    $service->checkObatKadaluarsa();
    
    // Verify no notification
    $this->assertDatabaseMissing('notifikasi', [
        'type' => 'obat_kadaluarsa',
        'role' => 'Admin',
    ]);
});

test('notifikasi tidak muncul ketika obat sudah kadaluarsa', function () {
    $obat = createTestObat();
    
    // Create batch dengan expiry date sudah berlalu
    StokBatch::create([
        'obat_id' => $obat->id,
        'no_batch' => 'BATCH-EXPIRE-003',
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'jumlah_masuk' => 100,
        'sisa_stok' => 100,
        'tgl_kadaluarsa' => now()->subDays(5),
        'pembelian_id' => null,
    ]);
    
    $service = new NotificationService();
    $service->checkObatKadaluarsa();
    
    // Verify no notification (sudah expired, bukan akan expired)
    $this->assertDatabaseMissing('notifikasi', [
        'type' => 'obat_kadaluarsa',
        'role' => 'Admin',
    ]);
});

test('notifikasi tidak muncul ketika batch kadaluarsa tapi stok kosong', function () {
    $obat = createTestObat();
    
    // Create batch dengan expiry date dalam 20 hari tapi stok 0
    StokBatch::create([
        'obat_id' => $obat->id,
        'no_batch' => 'BATCH-EXPIRE-004',
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'jumlah_masuk' => 100,
        'sisa_stok' => 0, // Stok sudah habis
        'tgl_kadaluarsa' => now()->addDays(20),
        'pembelian_id' => null,
    ]);
    
    $service = new NotificationService();
    $service->checkObatKadaluarsa();
    
    // Verify no notification (stok kosong, tidak perlu warning)
    $this->assertDatabaseMissing('notifikasi', [
        'type' => 'obat_kadaluarsa',
        'role' => 'Admin',
    ]);
});

test('notifikasi menampilkan jumlah batch yang akan kadaluarsa', function () {
    $obat1 = createTestObat();
    $obat2 = createTestObat();
    
    // Create 2 batches yang akan kadaluarsa
    StokBatch::create([
        'obat_id' => $obat1->id,
        'no_batch' => 'BATCH-EXPIRE-005',
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'jumlah_masuk' => 50,
        'sisa_stok' => 50,
        'tgl_kadaluarsa' => now()->addDays(15),
        'pembelian_id' => null,
    ]);
    
    StokBatch::create([
        'obat_id' => $obat2->id,
        'no_batch' => 'BATCH-EXPIRE-006',
        'harga_beli' => 3000,
        'harga_jual' => 5000,
        'jumlah_masuk' => 30,
        'sisa_stok' => 30,
        'tgl_kadaluarsa' => now()->addDays(25),
        'pembelian_id' => null,
    ]);
    
    $service = new NotificationService();
    $service->checkObatKadaluarsa();
    
    // Verify message contains count
    $this->assertDatabaseHas('notifikasi', [
        'type' => 'obat_kadaluarsa',
        'role' => 'Admin',
        'is_warning' => true,
        'message' => '2 batch akan kadaluarsa bulan ini',
    ]);
});

// ========== TEST 3: Kombinasi Notifikasi ==========

test('kedua notifikasi muncul ketika stok menipis dan akan kadaluarsa', function () {
    $obat = createTestObat(['stok_minimum' => 50]);
    
    // Create batch dengan stok menipis DAN akan kadaluarsa
    StokBatch::create([
        'obat_id' => $obat->id,
        'no_batch' => 'BATCH-COMBINED-001',
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'jumlah_masuk' => 30,
        'sisa_stok' => 30, // Stok menipis
        'tgl_kadaluarsa' => now()->addDays(20), // Akan kadaluarsa
        'pembelian_id' => null,
    ]);
    
    $service = new NotificationService();
    $service->checkStokMenipis();
    $service->checkObatKadaluarsa();
    
    // Both notifications should exist
    $this->assertDatabaseHas('notifikasi', [
        'type' => 'stok_menipis',
        'role' => 'Admin',
    ]);
    
    $this->assertDatabaseHas('notifikasi', [
        'type' => 'obat_kadaluarsa',
        'role' => 'Admin',
    ]);
});

test('generateSystemNotifications menjalankan semua checks', function () {
    $obat1 = createTestObat(['stok_minimum' => 50]);
    $obat2 = createTestObat();
    
    // Create menipis stock
    StokBatch::create([
        'obat_id' => $obat1->id,
        'no_batch' => 'BATCH-SYSTEM-001',
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'jumlah_masuk' => 30,
        'sisa_stok' => 30,
        'tgl_kadaluarsa' => now()->addYear(),
        'pembelian_id' => null,
    ]);
    
    // Create will-expire stock
    StokBatch::create([
        'obat_id' => $obat2->id,
        'no_batch' => 'BATCH-SYSTEM-002',
        'harga_beli' => 3000,
        'harga_jual' => 5000,
        'jumlah_masuk' => 50,
        'sisa_stok' => 50,
        'tgl_kadaluarsa' => now()->addDays(20),
        'pembelian_id' => null,
    ]);
    
    $service = new NotificationService();
    $service->generateSystemNotifications();
    
    // Verify both checks ran
    $this->assertDatabaseHas('notifikasi', [
        'type' => 'stok_menipis',
        'role' => 'Admin',
    ]);
    
    $this->assertDatabaseHas('notifikasi', [
        'type' => 'obat_kadaluarsa',
        'role' => 'Admin',
    ]);
});

// ========== TEST 4: Role-Based Notifications ==========

test('notifikasi stok_menipis hanya dikirim ke Admin dan Karyawan, bukan Kasir', function () {
    $obat = createTestObat(['stok_minimum' => 50]);
    
    StokBatch::create([
        'obat_id' => $obat->id,
        'no_batch' => 'BATCH-ROLE-001',
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'jumlah_masuk' => 30,
        'sisa_stok' => 30,
        'tgl_kadaluarsa' => now()->addYear(),
        'pembelian_id' => null,
    ]);
    
    $service = new NotificationService();
    $service->checkStokMenipis();
    
    // Should have notifications for Admin and Karyawan
    $this->assertDatabaseHas('notifikasi', [
        'type' => 'stok_menipis',
        'role' => 'Admin',
    ]);
    
    $this->assertDatabaseHas('notifikasi', [
        'type' => 'stok_menipis',
        'role' => 'Karyawan',
    ]);
    
    // Should NOT have notification for Kasir
    $this->assertDatabaseMissing('notifikasi', [
        'type' => 'stok_menipis',
        'role' => 'Kasir',
    ]);
    
    // Total should be exactly 2 (one for Admin, one for Karyawan)
    $notifCount = Notifikasi::where('type', 'stok_menipis')->count();
    $this->assertEquals(2, $notifCount);
});

test('notifikasi kadaluarsa juga hanya untuk Admin dan Karyawan', function () {
    $obat = createTestObat();
    
    StokBatch::create([
        'obat_id' => $obat->id,
        'no_batch' => 'BATCH-ROLE-002',
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'jumlah_masuk' => 100,
        'sisa_stok' => 100,
        'tgl_kadaluarsa' => now()->addDays(20),
        'pembelian_id' => null,
    ]);
    
    $service = new NotificationService();
    $service->checkObatKadaluarsa();
    
    // Should have notifications for Admin and Karyawan
    $adminNotif = Notifikasi::where('type', 'obat_kadaluarsa')
        ->where('role', 'Admin')
        ->first();
    $this->assertNotNull($adminNotif);
    
    $karyawanNotif = Notifikasi::where('type', 'obat_kadaluarsa')
        ->where('role', 'Karyawan')
        ->first();
    $this->assertNotNull($karyawanNotif);
    
    // Should NOT have notification for Kasir
    $kasirNotif = Notifikasi::where('type', 'obat_kadaluarsa')
        ->where('role', 'Kasir')
        ->first();
    $this->assertNull($kasirNotif);
});

// ========== HELPER FUNCTIONS ==========

function createTestObat(array $attributes = []): Obat
{
    $kategori = KategoriObat::firstOrCreate(
        ['nama_kategori' => 'Test Kategori'],
        ['uuid' => Str::uuid()]
    );
    
    $satuan = SatuanObat::firstOrCreate(
        ['nama_satuan' => 'Test Satuan'],
        ['uuid' => Str::uuid(), 'faktor_konversi' => 1]
    );
    
    return Obat::create(array_merge([
        'uuid' => Str::uuid(),
        'nama_obat' => 'Test Obat ' . Str::random(6),
        'kode_obat' => 'OBAT-' . strtoupper(Str::random(6)),
        'kategori_id' => $kategori->id,
        'satuan_obat_id' => $satuan->id,
        'stok_minimum' => 20,
        'is_racikan' => false,
        'lokasi_rak' => 'A-01',
        'barcode' => strtoupper(Str::random(13)),
        'deskripsi' => 'Test obat untuk notifikasi',
    ], $attributes));
}
