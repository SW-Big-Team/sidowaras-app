<?php

use App\Http\Middleware\EnsureSingleSession;
use App\Models\Role;
use App\Models\User;
use App\Models\Obat;
use App\Models\KategoriObat;
use App\Models\SatuanObat;
use App\Models\StockOpname;
use App\Models\DetailStockOpname;
use App\Models\StokBatch;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->withoutMiddleware(EnsureSingleSession::class);
    // Create roles
    Role::firstOrCreate(['nama_role' => 'Admin'], ['uuid' => Str::uuid()]);
    Role::firstOrCreate(['nama_role' => 'Karyawan'], ['uuid' => Str::uuid()]);
    Role::firstOrCreate(['nama_role' => 'Kasir'], ['uuid' => Str::uuid()]);
});

// Helper untuk bypass RoleMiddleware untuk test positif
function bypassRoleMiddleware() {
    return test()->withoutMiddleware(\App\Http\Middleware\RoleMiddleware::class);
}

// ========== TEST 1: Karyawan bisa input stok opname ==========

test('karyawan dapat membuat stock opname', function () {
    bypassRoleMiddleware();
    
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@karyawan@gmail.com',
    ]);
    
    $obat = createObatWithBatch();
    
    $data = [
        'physical_qty' => [
            $obat->id => 45,
        ],
        'notes' => [
            $obat->id => 'Ada 5 unit yang hilang',
        ],
    ];
    
    $response = $this->actingAs($karyawan)->post('/shared/stok-opname', $data);
    
    $response->assertStatus(302);
    $response->assertSessionHas('success');
    
    $this->assertDatabaseHas('stock_opname', [
        'tanggal' => today(),
        'status' => 'pending',
        'created_by' => $karyawan->id,
    ]);
});

test('karyawan dapat akses form create stock opname', function () {
    bypassRoleMiddleware();
    
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    createObatWithBatch();
    
    $response = $this->actingAs($karyawan)->get('/shared/stok-opname/create');
    
    $response->assertStatus(200);
    $response->assertViewIs('shared.stokopname.create');
});

// ========== TEST 2: Admin bisa input opname ==========

test('admin dapat membuat stock opname', function () {
    bypassRoleMiddleware();
    
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createObatWithBatch();
    
    $data = [
        'physical_qty' => [
            $obat->id => 50,
        ],
        'notes' => [
            $obat->id => '',
        ],
    ];
    
    $response = $this->actingAs($admin)->post('/shared/stok-opname', $data);
    
    $response->assertStatus(302);
    $response->assertSessionHas('success');
});

test('admin dapat akses form create stock opname', function () {
    bypassRoleMiddleware();
    
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    createObatWithBatch();
    
    $response = $this->actingAs($admin)->get('/shared/stok-opname/create');
    
    $response->assertStatus(200);
    $response->assertViewIs('shared.stokopname.create');
});

// ========== TEST 3: Admin bisa lihat detail stock opname ==========

test('admin dapat melihat detail stock opname yang dibuat karyawan', function () {
    bypassRoleMiddleware();
    
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createObatWithBatch();
    
    $opname = StockOpname::create([
        'tanggal' => today(),
        'status' => 'pending',
        'created_by' => $karyawan->id,
    ]);
    
    DetailStockOpname::create([
        'stock_opname_id' => $opname->id,
        'obat_id' => $obat->id,
        'system_qty' => 50,
        'physical_qty' => 45,
        'notes' => 'Ada yang hilang',
    ]);
    
    $response = $this->actingAs($admin)->get("/shared/stok-opname/{$opname->id}");
    
    $response->assertStatus(200);
    $response->assertViewIs('shared.stokopname.show');
});

// ========== TEST 4: Selisih stok dihitung dengan benar ==========

test('selisih stok kurang dihitung dengan benar', function () {
    bypassRoleMiddleware();
    
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createObatWithBatch(50);
    $batch = $obat->stokBatches()->first();
    
    $opname = StockOpname::create([
        'tanggal' => today(),
        'status' => 'pending',
        'created_by' => $karyawan->id,
    ]);
    
    DetailStockOpname::create([
        'stock_opname_id' => $opname->id,
        'obat_id' => $obat->id,
        'system_qty' => 50,
        'physical_qty' => 45, // kurang 5
    ]);
    
    $response = $this->actingAs($admin)->post("/adminx/stok-opname/{$opname->id}/approve");
    
    $response->assertStatus(302);
    $response->assertSessionHas('success');
    
    $batch->refresh();
    $this->assertEquals(45, $batch->sisa_stok);
});

test('selisih stok lebih dihitung dengan benar', function () {
    bypassRoleMiddleware();
    
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createObatWithBatch(50);
    $batch = $obat->stokBatches()->first();
    
    $opname = StockOpname::create([
        'tanggal' => today(),
        'status' => 'pending',
        'created_by' => $karyawan->id,
    ]);
    
    DetailStockOpname::create([
        'stock_opname_id' => $opname->id,
        'obat_id' => $obat->id,
        'system_qty' => 50,
        'physical_qty' => 60, // lebih 10
    ]);
    
    $response = $this->actingAs($admin)->post("/adminx/stok-opname/{$opname->id}/approve");
    
    $response->assertStatus(302);
    $response->assertSessionHas('success');
    
    $batch->refresh();
    $this->assertEquals(60, $batch->sisa_stok);
});

// ========== TEST 5: Kasir tidak bisa input opname ==========

test('kasir tidak dapat mengakses form create stock opname', function () {
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    createObatWithBatch();
    
    $response = $this->actingAs($kasir)->get('/shared/stok-opname/create');
    
    $response->assertStatus(403);
});

test('kasir tidak dapat membuat stock opname', function () {
    $kasir = createUser([
        'role_id' => Role::where('nama_role', 'Kasir')->first()->id,
        'email' => 'kasir-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createObatWithBatch();
    
    $data = [
        'physical_qty' => [
            $obat->id => 45,
        ],
        'notes' => [
            $obat->id => 'Test',
        ],
    ];
    
    $response = $this->actingAs($kasir)->post('/shared/stok-opname', $data);
    
    $response->assertStatus(403);
});

// ========== TEST 6: Validasi Input ==========

test('stock opname harus punya minimal satu item obat', function () {
    bypassRoleMiddleware();
    
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    createObatWithBatch();
    
    // Empty data
    $data = [
        'physical_qty' => [],
        'notes' => [],
    ];
    
    $response = $this->actingAs($karyawan)->post('/shared/stok-opname', $data);
    
    $response->assertStatus(302);
    $response->assertSessionHasErrors();
});

test('physical_qty harus integer dan >= 0', function () {
    bypassRoleMiddleware();
    
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createObatWithBatch();
    
    // Negative quantity
    $data = [
        'physical_qty' => [
            $obat->id => -5,
        ],
        'notes' => [
            $obat->id => '',
        ],
    ];
    
    $response = $this->actingAs($karyawan)->post('/shared/stok-opname', $data);
    
    $response->assertStatus(302);
    $response->assertSessionHasErrors();
});

test('tidak boleh ada duplikasi stock opname dalam sehari', function () {
    bypassRoleMiddleware();
    
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createObatWithBatch();
    
    $data = [
        'physical_qty' => [
            $obat->id => 45,
        ],
        'notes' => [
            $obat->id => 'First opname',
        ],
    ];
    
    // First opname
    $this->actingAs($karyawan)->post('/shared/stok-opname', $data);
    
    // Try to create second opname hari yang sama
    $data['notes'][$obat->id] = 'Second opname';
    $response = $this->actingAs($karyawan)->post('/shared/stok-opname', $data);
    
    $response->assertSessionHasErrors();
});

// ========== TEST 7: Status Flow ==========

test('stock opname dibuat dengan status pending', function () {
    bypassRoleMiddleware();
    
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createObatWithBatch();
    
    $data = [
        'physical_qty' => [
            $obat->id => 45,
        ],
        'notes' => [
            $obat->id => 'Test',
        ],
    ];
    
    $this->actingAs($karyawan)->post('/shared/stok-opname', $data);
    
    $opname = StockOpname::where('created_by', $karyawan->id)->first();
    $this->assertEquals('pending', $opname->status);
    $this->assertNull($opname->approved_by);
    $this->assertNull($opname->approved_at);
});

test('status berubah ke approved setelah admin approve', function () {
    bypassRoleMiddleware();
    
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createObatWithBatch(50);
    
    $opname = StockOpname::create([
        'tanggal' => today(),
        'status' => 'pending',
        'created_by' => $karyawan->id,
    ]);
    
    DetailStockOpname::create([
        'stock_opname_id' => $opname->id,
        'obat_id' => $obat->id,
        'system_qty' => 50,
        'physical_qty' => 50,
    ]);
    
    $this->actingAs($admin)->post("/adminx/stok-opname/{$opname->id}/approve");
    
    $opname->refresh();
    $this->assertEquals('approved', $opname->status);
    $this->assertNotNull($opname->approved_by);
    $this->assertNotNull($opname->approved_at);
});

test('status berubah ke rejected setelah admin reject', function () {
    bypassRoleMiddleware();
    
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createObatWithBatch();
    
    $opname = StockOpname::create([
        'tanggal' => today(),
        'status' => 'pending',
        'created_by' => $karyawan->id,
    ]);
    
    DetailStockOpname::create([
        'stock_opname_id' => $opname->id,
        'obat_id' => $obat->id,
        'system_qty' => 50,
        'physical_qty' => 45,
    ]);
    
    $this->actingAs($admin)->post("/adminx/stok-opname/{$opname->id}/reject");
    
    $opname->refresh();
    $this->assertEquals('rejected', $opname->status);
});

// ========== TEST 8: Edge Cases ==========

test('tidak ada perubahan stok jika physical_qty sama dengan system_qty', function () {
    bypassRoleMiddleware();
    
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
        'email' => 'karyawan-' . Str::uuid() . '@example.com',
    ]);
    
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
        'email' => 'admin-' . Str::uuid() . '@example.com',
    ]);
    
    $obat = createObatWithBatch(50);
    $batch = $obat->stokBatches()->first();
    
    $opname = StockOpname::create([
        'tanggal' => today(),
        'status' => 'pending',
        'created_by' => $karyawan->id,
    ]);
    
    DetailStockOpname::create([
        'stock_opname_id' => $opname->id,
        'obat_id' => $obat->id,
        'system_qty' => 50,
        'physical_qty' => 50, // Sama
    ]);
    
    $this->actingAs($admin)->post("/adminx/stok-opname/{$opname->id}/approve");
    
    $batch->refresh();
    $this->assertEquals(50, $batch->sisa_stok); // No change
});


function createObatWithBatch($initialStock = 50): Obat
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
        'deskripsi' => 'Test obat untuk stock opname',
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
