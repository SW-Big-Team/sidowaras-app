<?php

use App\Http\Middleware\EnsureSingleSession;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Str;

beforeEach(function () {
    /** @var \Tests\TestCase $this */
    $this->withoutMiddleware(EnsureSingleSession::class);

    Role::firstOrCreate(['nama_role' => 'Admin'], ['uuid' => Str::uuid()]);
    Role::firstOrCreate(['nama_role' => 'Karyawan'], ['uuid' => Str::uuid()]);
});

test('guest tidak dapat melihat daftar supplier', function () {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/adminx/supplier');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
});

test('admin dapat melihat daftar supplier', function () {
    /** @var \Tests\TestCase $this */
    $admin = createSupplierAdminUser();

    $response = $this->actingAs($admin)->get('/adminx/supplier');

    $response->assertStatus(200);
    $response->assertViewIs('admin.supplier.index');
});

test('admin dapat membuat supplier baru', function () {
    /** @var \Tests\TestCase $this */
    $admin = createSupplierAdminUser();

    $payload = [
        'supplier_name' => 'PT Sehat Sentosa',
        'supplier_phone' => '08123456789',
        'supplier_address' => 'Jl. Kesehatan No.1',
        'supplier_email' => 'contact@sehat.com',
        'supplier_status' => true,
    ];

    $response = $this->actingAs($admin)->post('/adminx/supplier', $payload);

    $response->assertStatus(302);
    $response->assertRedirect('/adminx/supplier');
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('supplier', [
        'supplier_name' => 'PT Sehat Sentosa',
        'supplier_phone' => '08123456789',
    ]);
});

test('validasi store supplier gagal ketika data tidak lengkap', function () {
    /** @var \Tests\TestCase $this */
    $admin = createSupplierAdminUser();

    $response = $this->actingAs($admin)->post('/adminx/supplier', []);

    $response->assertStatus(302);
    $response->assertSessionHasErrors([
        'supplier_name',
        'supplier_phone',
    ]);
});

test('store supplier akan me-restore data yang soft deleted', function () {
    /** @var \Tests\TestCase $this */
    $admin = createSupplierAdminUser();
    $trashed = Supplier::create([
        'supplier_name' => 'PT Lama',
        'supplier_phone' => '08111',
        'supplier_address' => 'Alamat lama',
        'supplier_email' => 'lama@example.com',
    ]);
    $trashed->delete();

    $response = $this->actingAs($admin)->post('/adminx/supplier', [
        'supplier_name' => 'PT Lama',
        'supplier_phone' => '08222',
        'supplier_address' => 'Alamat baru',
        'supplier_email' => 'baru@example.com',
    ]);

    $response->assertStatus(302);
    $response->assertRedirect('/adminx/supplier');
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('supplier', [
        'id' => $trashed->id,
        'supplier_phone' => '08222',
        'deleted_at' => null,
    ]);
});

test('admin dapat memperbarui supplier', function () {
    /** @var \Tests\TestCase $this */
    $admin = createSupplierAdminUser();
    $supplier = Supplier::create([
        'supplier_name' => 'PT Update',
        'supplier_phone' => '08000',
    ]);

    $response = $this->actingAs($admin)->put("/adminx/supplier/{$supplier->id}", [
        'supplier_name' => 'PT Update Baru',
        'supplier_phone' => '08999',
    ]);

    $response->assertStatus(302);
    $response->assertRedirect('/adminx/supplier');
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('supplier', [
        'id' => $supplier->id,
        'supplier_name' => 'PT Update Baru',
        'supplier_phone' => '08999',
    ]);
});

test('update supplier gagal bila nama duplikat', function () {
    /** @var \Tests\TestCase $this */
    $admin = createSupplierAdminUser();
    $first = Supplier::create([
        'supplier_name' => 'PT A',
        'supplier_phone' => '08001',
    ]);
    $second = Supplier::create([
        'supplier_name' => 'PT B',
        'supplier_phone' => '08002',
    ]);

    $response = $this->actingAs($admin)->put("/adminx/supplier/{$second->id}", [
        'supplier_name' => $first->supplier_name,
        'supplier_phone' => '08003',
    ]);

    $response->assertStatus(302);
    $response->assertSessionHasErrors('supplier_name');
});

test('admin dapat menghapus supplier', function () {
    /** @var \Tests\TestCase $this */
    $admin = createSupplierAdminUser();
    $supplier = Supplier::create([
        'supplier_name' => 'PT Hapus',
        'supplier_phone' => '08004',
    ]);

    $response = $this->actingAs($admin)->delete("/adminx/supplier/{$supplier->id}");

    $response->assertStatus(302);
    $response->assertRedirect('/adminx/supplier');
    $response->assertSessionHas('success');
    $this->assertSoftDeleted('supplier', ['id' => $supplier->id]);
});

function createSupplierAdminUser(array $attributes = []): User
{
    $roleId = Role::where('nama_role', 'Admin')->value('id');

    return User::create(array_merge([
        'uuid' => Str::uuid(),
        'role_id' => $roleId,
        'nama_lengkap' => 'Admin Supplier',
        'email' => 'admin.supplier.' . Str::random(5) . '@example.com',
        'password' => 'password',
        'is_active' => true,
    ], $attributes));
}

