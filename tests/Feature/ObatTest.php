<?php

use App\Http\Middleware\EnsureSingleSession;
use App\Models\Role;
use App\Models\Obat;
use App\Models\KategoriObat;
use App\Models\SatuanObat;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->withoutMiddleware(EnsureSingleSession::class);
    // Create roles
    Role::create(['uuid' => Str::uuid(), 'nama_role' => 'Admin']);
    Role::create(['uuid' => Str::uuid(), 'nama_role' => 'Karyawan']);
    Role::create(['uuid' => Str::uuid(), 'nama_role' => 'Kasir']);
});

// ========== OBAT TESTS ==========

test('guest tidak dapat lihat daftar obat', function () {
    $response = $this->get('/adminx/obat');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
});

test('authenticated user bisa lihat daftar obat', function () {
    $user = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
    ]);
    $response = $this->actingAs($user)->get('/adminx/obat');
    $response->assertStatus(200);
    $response->assertViewIs('admin.obat.index');
});

test('admin dapat membuat obat baru', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
    ]);
    
    $kategori = createKategoriObat();
    $satuan = createSatuanObat();
    
    $obatData = [
        'nama_obat' => 'Test Obat',
        'kategori_id' => $kategori->id,
        'satuan_obat_id' => $satuan->id,
        'stok_minimum' => 10,
        'lokasi_rak' => 'A-01',
        'barcode' => '1234567890' . Str::random(3),
        'deskripsi' => 'Deskripsi test obat',
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'stok_awal' => 100,
        'tgl_kadaluarsa' => now()->addYear()->format('Y-m-d'),
        'nama_pengirim' => 'Supplier Test',
    ];
    
    $response = $this->actingAs($admin)->post('/adminx/obat', $obatData);
    
    $response->assertStatus(302);
    $response->assertRedirect('/adminx/obat');
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('obat', [
        'nama_obat' => 'Test Obat',
        'kategori_id' => $kategori->id,
        'satuan_obat_id' => $satuan->id,
    ]);
});

test('non-admin tidak dapat membuat obat baru', function () {
    $karyawan = createUser([
        'role_id' => Role::where('nama_role', 'Karyawan')->first()->id,
    ]);
    
    $kategori = createKategoriObat();
    $satuan = createSatuanObat();
    
    $obatData = [
        'nama_obat' => 'Test Obat',
        'kategori_id' => $kategori->id,
        'satuan_obat_id' => $satuan->id,
        'harga_beli' => 5000,
        'harga_jual' => 7000,
        'stok_awal' => 100,
        'tgl_kadaluarsa' => now()->addYear()->format('Y-m-d'),
        'nama_pengirim' => 'Supplier Test',
    ];
    
    $response = $this->actingAs($karyawan)->post('/adminx/obat', $obatData);
    
    $response->assertStatus(403);
    $this->assertDatabaseMissing('obat', [
        'nama_obat' => 'Test Obat',
    ]);
});

test('admin dapat mengupdate obat', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
    ]);
    
    $kategori = createKategoriObat();
    $satuan = createSatuanObat();
    $obat = createObat([
        'kategori_id' => $kategori->id,
        'satuan_obat_id' => $satuan->id,
    ]);
    
    $updateData = [
        'nama_obat' => 'Obat Updated',
        'kode_obat' => $obat->kode_obat,
        'kategori_id' => $kategori->id,
        'satuan_obat_id' => $satuan->id,
        'stok_minimum' => 20,
        'lokasi_rak' => 'B-02',
        'deskripsi' => 'Deskripsi updated',
    ];
    
    $response = $this->actingAs($admin)->put("/adminx/obat/{$obat->id}", $updateData);
    
    $response->assertStatus(302);
    $response->assertRedirect('/adminx/obat');
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('obat', [
        'id' => $obat->id,
        'nama_obat' => 'Obat Updated',
        'stok_minimum' => 20,
    ]);
});

test('admin dapat menghapus obat', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
    ]);
    
    $kategori = createKategoriObat();
    $satuan = createSatuanObat();
    $obat = createObat([
        'kategori_id' => $kategori->id,
        'satuan_obat_id' => $satuan->id,
    ]);
    
    $response = $this->actingAs($admin)->delete("/adminx/obat/{$obat->id}");
    
    $response->assertStatus(302);
    $response->assertRedirect('/adminx/obat');
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('obat', [
        'id' => $obat->id,
    ]);
});

test('validasi store obat gagal jika data tidak lengkap', function () {
    $admin = createUser([
        'role_id' => Role::where('nama_role', 'Admin')->first()->id,
    ]);
    
    $response = $this->actingAs($admin)->post('/adminx/obat', []);
    
    $response->assertStatus(302);
    $response->assertSessionHasErrors(['nama_obat', 'kategori_id', 'satuan_obat_id', 'harga_beli', 'harga_jual', 'stok_awal', 'tgl_kadaluarsa', 'nama_pengirim']);
});

// ========== HELPER FUNCTIONS ==========

function createKategoriObat(array $attributes = []): KategoriObat
{
    return KategoriObat::create(array_merge([
        'uuid' => Str::uuid(),
        'nama_kategori' => 'Test Kategori ' . Str::random(6),
    ], $attributes));
}

function createSatuanObat(array $attributes = []): SatuanObat
{
    return SatuanObat::create(array_merge([
        'uuid' => Str::uuid(),
        'nama_satuan' => 'Test Satuan ' . Str::random(6),
        'faktor_konversi' => 1,
    ], $attributes));
}

function createObat(array $attributes = []): Obat
{
    $kategori = KategoriObat::first() ?? createKategoriObat();
    $satuan = SatuanObat::first() ?? createSatuanObat();
    
    return Obat::create(array_merge([
        'uuid' => Str::uuid(),
        'nama_obat' => 'Test Obat',
        'kode_obat' => 'OBAT-' . strtoupper(Str::random(6)),
        'kategori_id' => $kategori->id,
        'satuan_obat_id' => $satuan->id,
        'stok_minimum' => 10,
        'is_racikan' => false,
        'lokasi_rak' => 'A-01',
        'barcode' => '1234567890123',
        'deskripsi' => 'Deskripsi test',
    ], $attributes));
}
