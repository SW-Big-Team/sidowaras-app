<?php

use App\Http\Middleware\EnsureSingleSession;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

beforeEach(function () {
    // Create roles
    Role::create(['uuid' => Str::uuid(), 'nama_role' => 'Admin']);
    Role::create(['uuid' => Str::uuid(), 'nama_role' => 'Karyawan']);
    Role::create(['uuid' => Str::uuid(), 'nama_role' => 'Kasir']);
});

// ========== LOGIN TESTS ==========

test('guest can view login page', function () {
    $response = $this->withoutMiddleware(EnsureSingleSession::class)
    ->get('/login');
    
    $response->assertStatus(200);
    $response->assertViewIs('auth.login');
});

test('authenticated user cannot view login page', function () {
    $user = createUser();
    
    $response = $this->actingAs($user)->get('/login');
    
    $response->assertRedirect('/home');
});

test('user can login with correct credentials', function () {
    $user = createUser([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
        'is_active' => true,
    ]);
    
    $response = $this->post('/login', [
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);
    
    $response->assertRedirect('/karyawan/dashboard');
    $this->assertAuthenticatedAs($user);
});

test('user cannot login with incorrect password', function () {
    createUser([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
    ]);
    
    $response = $this->post('/login', [
        'email' => 'test@example.com',
        'password' => 'wrongpassword',
    ]);
    
    $response->assertSessionHasErrors();
    $this->assertGuest();
});

test('user cannot login with non-existent email', function () {
    $response = $this->post('/login', [
        'email' => 'nonexistent@example.com',
        'password' => 'password123',
    ]);
    
    $response->assertSessionHasErrors();
    $this->assertGuest();
});

test('login requires email', function () {
    $response = $this->post('/login', [
        'password' => 'password123',
    ]);
    
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('login requires password', function () {
    $response = $this->post('/login', [
        'email' => 'test@example.com',
    ]);
    
    $response->assertSessionHasErrors('password');
    $this->assertGuest();
});

// Currently, not ready yet
test('inactive user can login but should be blocked by middleware', function () {
    $user = createUser([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
        'is_active' => false,
    ]);
    
    $response = $this->post('/login', [
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);
    
    $this->assertAuthenticatedAs($user);
})->skip('Inactive user checking not implemented yet');

test('remember me functionality works', function () {
    $user = createUser([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
    ]);
    
    $response = $this->post('/login', [
        'email' => 'test@example.com',
        'password' => 'password123',
        'remember' => true,
    ]);
    
    $response->assertRedirect('/karyawan/dashboard');
    $this->assertAuthenticatedAs($user);
    
    // Check if remember token is set on user
    $user->refresh();
    expect($user->remember_token)->not->toBeNull();
});

// ========== LOGOUT TESTS ==========

test('authenticated user can logout', function () {
    $user = createUser();
    
    $response = $this->actingAs($user)->post('/logout');
    
    $response->assertRedirect('/');
    $this->assertGuest();
});

test('guest cannot logout', function () {
    $response = $this->post('/logout');
    
    $response->assertRedirect('/login');
});

// ========== PASSWORD RESET TESTS ==========

test('guest can view password reset request page', function () {
    // Mock Vite to avoid manifest not found error in testing
    $this->withoutVite();
    
    $response = $this->get('/password/reset');
    
    $response->assertStatus(200);
    $response->assertViewIs('auth.passwords.email');
});

test('user can request password reset link', function () {
    $user = createUser(['email' => 'test@example.com']);
    
    $response = $this->post('/password/email', [
        'email' => 'test@example.com',
    ]);
    
    $response->assertSessionHas('status');
});

test('password reset request requires valid email', function () {
    $response = $this->post('/password/email', [
        'email' => 'invalid-email',
    ]);
    
    $response->assertSessionHasErrors('email');
});

test('password reset request fails for non-existent email', function () {
    $response = $this->post('/password/email', [
        'email' => 'nonexistent@example.com',
    ]);
    
    $response->assertSessionHasErrors('email');
});

// ========== HELPER FUNCTIONS ==========

function createUser(array $attributes = []): User
{
    $role = Role::where('nama_role', 'Karyawan')->first();
    
    return User::create(array_merge([
        'uuid' => Str::uuid(),
        'role_id' => $role->id,
        'nama_lengkap' => 'Test User',
        'email' => 'user@example.com',
        'password' => Hash::make('password'),
        'is_active' => true,
    ], $attributes));
}
