<?php

use App\Http\Middleware\EnsureSingleSession;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

beforeEach(function () {
    /** @var \Tests\TestCase $this */
    $this->withoutMiddleware(EnsureSingleSession::class);

    collect(['Admin', 'Karyawan', 'Kasir'])->each(function ($roleName) {
        Role::firstOrCreate(
            ['nama_role' => $roleName],
            ['uuid' => Str::uuid()]
        );
    });
});

test('guest tidak dapat mengakses halaman pengguna', function () {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/adminx/users');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
});

test('admin dapat melihat daftar pengguna', function () {
    /** @var \Tests\TestCase $this */
    $admin = createUserForAdminControllerTests();

    $response = $this->actingAs($admin)->get('/adminx/users');

    $response->assertStatus(200);
    $response->assertViewIs('admin.users.index');
});

test('admin dapat membuka halaman create user', function () {
    /** @var \Tests\TestCase $this */
    $admin = createUserForAdminControllerTests();

    $response = $this->actingAs($admin)->get('/adminx/users/create');

    $response->assertStatus(200);
    $response->assertViewIs('admin.users.create');
});

test('admin dapat membuat user baru', function () {
    /** @var \Tests\TestCase $this */
    $admin = createUserForAdminControllerTests();
    $roleId = Role::where('nama_role', 'Karyawan')->value('id');

    $response = $this->actingAs($admin)->post('/adminx/users', [
        'nama_lengkap' => 'Karyawan Baru',
        'email' => 'karyawan.baru@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role_id' => $roleId,
        'is_active' => true,
    ]);

    $response->assertStatus(302);
    $response->assertRedirect('/adminx/users');
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'email' => 'karyawan.baru@example.com',
        'role_id' => $roleId,
    ]);
});

test('validasi pembuatan user gagal jika data tidak lengkap', function () {
    /** @var \Tests\TestCase $this */
    $admin = createUserForAdminControllerTests();

    $response = $this->actingAs($admin)->post('/adminx/users', []);

    $response->assertStatus(302);
    $response->assertSessionHasErrors([
        'nama_lengkap',
        'email',
        'password',
        'role_id',
    ]);
});

test('admin dapat membuka halaman edit user', function () {
    /** @var \Tests\TestCase $this */
    $admin = createUserForAdminControllerTests();
    $user = createUserForAdminControllerTests('Karyawan');

    $response = $this->actingAs($admin)->get("/adminx/users/{$user->id}/edit");

    $response->assertStatus(200);
    $response->assertViewIs('admin.users.edit');
});

test('admin dapat mengupdate user', function () {
    /** @var \Tests\TestCase $this */
    $admin = createUserForAdminControllerTests();
    $user = createUserForAdminControllerTests('Karyawan', [
        'email' => 'old@example.com',
    ]);
    $roleId = Role::where('nama_role', 'Kasir')->value('id');

    $response = $this->actingAs($admin)->put("/adminx/users/{$user->id}", [
        'nama_lengkap' => 'Nama Baru',
        'email' => 'new@example.com',
        'role_id' => $roleId,
        'is_active' => false,
        'password' => 'newpassword',
        'password_confirmation' => 'newpassword',
    ]);

    $response->assertStatus(302);
    $response->assertRedirect('/adminx/users');
    $response->assertSessionHas('success');

    $user->refresh();
    expect($user->nama_lengkap)->toBe('Nama Baru');
    expect($user->role_id)->toBe($roleId);
    expect($user->is_active)->toBeFalse();
    expect(Hash::check('newpassword', $user->password))->toBeTrue();
});

test('update user gagal ketika email duplikat', function () {
    /** @var \Tests\TestCase $this */
    $admin = createUserForAdminControllerTests();
    $userA = createUserForAdminControllerTests('Karyawan', ['email' => 'first@example.com']);
    $userB = createUserForAdminControllerTests('Kasir', ['email' => 'second@example.com']);

    $response = $this->actingAs($admin)->put("/adminx/users/{$userB->id}", [
        'nama_lengkap' => 'Kasir',
        'email' => 'first@example.com',
        'role_id' => $userB->role_id,
        'is_active' => true,
    ]);

    $response->assertStatus(302);
    $response->assertSessionHasErrors('email');
});

test('admin dapat toggle status user lain', function () {
    /** @var \Tests\TestCase $this */
    $admin = createUserForAdminControllerTests();
    $user = createUserForAdminControllerTests('Karyawan');

    $response = $this->actingAs($admin)->patch("/adminx/users/{$user->id}/toggle-status");

    $response->assertStatus(200);
    $response->assertJson(['success' => true]);

    $user->refresh();
    expect($user->is_active)->toBeFalse();
});

test('toggle status gagal ketika mencoba mengubah akun sendiri', function () {
    /** @var \Tests\TestCase $this */
    $admin = createUserForAdminControllerTests();

    $response = $this->actingAs($admin)->patch("/adminx/users/{$admin->id}/toggle-status");

    $response->assertStatus(403);
    $response->assertJson(['success' => false]);
});

test('admin dapat menghapus user lain', function () {
    /** @var \Tests\TestCase $this */
    $admin = createUserForAdminControllerTests();
    $user = createUserForAdminControllerTests('Karyawan');

    $response = $this->actingAs($admin)->delete("/adminx/users/{$user->id}");

    $response->assertStatus(302);
    $response->assertRedirect('/adminx/users');
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

test('admin tidak dapat menghapus akun sendiri', function () {
    /** @var \Tests\TestCase $this */
    $admin = createUserForAdminControllerTests();

    $response = $this->actingAs($admin)->delete("/adminx/users/{$admin->id}");

    $response->assertStatus(302);
    $response->assertRedirect('/adminx/users');
    $response->assertSessionHas('error');
    $this->assertDatabaseHas('users', ['id' => $admin->id]);
});

function createUserForAdminControllerTests(string $roleName = 'Admin', array $attributes = []): User
{
    $roleId = Role::where('nama_role', $roleName)->value('id');

    return User::create(array_merge([
        'uuid' => Str::uuid(),
        'role_id' => $roleId,
        'nama_lengkap' => $roleName . ' User ' . Str::random(4),
        'email' => strtolower($roleName) . '.' . Str::random(6) . '@example.com',
        'password' => 'password',
        'is_active' => true,
    ], $attributes));
}

