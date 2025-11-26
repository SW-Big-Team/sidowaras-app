<?php

use App\Http\Middleware\EnsureSingleSession;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\KategoriObat;
use App\Models\Obat;
use App\Models\Role;
use App\Models\SatuanObat;
use App\Models\Shift;
use App\Models\StokBatch;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Support\Str;
use Carbon\Carbon;

beforeEach(function () {
    /** @var \Tests\TestCase $this */
    $this->withoutMiddleware(EnsureSingleSession::class);

    collect(['Admin', 'Karyawan', 'Kasir'])->each(function ($role) {
        Role::firstOrCreate(
            ['nama_role' => $role],
            ['uuid' => Str::uuid()]
        );
    });

    $this->mock(NotificationService::class, function ($mock) {
        $mock->shouldReceive('notifyCartApproved')->andReturnNull();
        $mock->shouldReceive('notifyCartRejected')->andReturnNull();
        $mock->shouldReceive('generateSystemNotifications')->andReturnNull();
        $mock->shouldReceive('getNotificationsForUser')->andReturn(collect());
        $mock->shouldReceive('getUnreadCount')->andReturn(0);
    });
});

test('guest tidak dapat melihat cart karyawan', function () {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/karyawan/cart');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
});

test('karyawan dapat melihat halaman cart', function () {
    /** @var \Tests\TestCase $this */
    $karyawan = createUserWithRole('Karyawan');
    ensureUserHasActiveShift($karyawan);

    $response = $this->actingAs($karyawan)->get('/karyawan/cart');

    $response->assertStatus(200);
    $response->assertViewIs('karyawan.cart.index');
});

test('karyawan dapat menambahkan obat ke cart ketika stok cukup', function () {
    /** @var \Tests\TestCase $this */
    $karyawan = createUserWithRole('Karyawan');
    ensureUserHasActiveShift($karyawan);
    $obat = createCartObat();
    addStockToObat($obat, 20, 15000);

    $response = $this->actingAs($karyawan)->post('/karyawan/cart/add', [
        'obat_id' => $obat->id,
        'jumlah' => 5,
    ]);

    $response->assertStatus(302);
    $response->assertSessionHas('success', 'Obat berhasil ditambahkan ke keranjang.');

    $this->assertDatabaseHas('cart_items', [
        'obat_id' => $obat->id,
        'jumlah' => 5,
    ]);
});

test('karyawan gagal menambahkan obat saat stok habis', function () {
    /** @var \Tests\TestCase $this */
    $karyawan = createUserWithRole('Karyawan');
    ensureUserHasActiveShift($karyawan);
    $obat = createCartObat();

    $response = $this->actingAs($karyawan)->post('/karyawan/cart/add', [
        'obat_id' => $obat->id,
        'jumlah' => 1,
    ]);

    $response->assertStatus(302);
    $response->assertSessionHasErrors('obat_id');
});

test('karyawan gagal menambahkan obat ketika jumlah melebihi stok', function () {
    /** @var \Tests\TestCase $this */
    $karyawan = createUserWithRole('Karyawan');
    ensureUserHasActiveShift($karyawan);
    $obat = createCartObat();
    addStockToObat($obat, 3, 12000);

    $response = $this->actingAs($karyawan)->post('/karyawan/cart/add', [
        'obat_id' => $obat->id,
        'jumlah' => 5,
    ]);

    $response->assertStatus(302);
    $response->assertSessionHasErrors('jumlah');
});

test('karyawan dapat menghapus item cart', function () {
    /** @var \Tests\TestCase $this */
    $karyawan = createUserWithRole('Karyawan');
    ensureUserHasActiveShift($karyawan);
    $obat = createCartObat();
    addStockToObat($obat, 10, 10000);

    $cart = Cart::create([
        'user_id' => $karyawan->id,
        'is_approved' => false,
    ]);

    $item = CartItem::create([
        'cart_id' => $cart->id,
        'obat_id' => $obat->id,
        'jumlah' => 2,
        'harga_satuan' => 10000,
    ]);

    $response = $this->actingAs($karyawan)->delete("/karyawan/cart/item/{$item->id}");

    $response->assertStatus(302);
    $this->assertDatabaseMissing('cart_items', ['id' => $item->id]);
});

test('checkout gagal ketika cart kosong', function () {
    /** @var \Tests\TestCase $this */
    $karyawan = createUserWithRole('Karyawan');
    ensureUserHasActiveShift($karyawan);

    $response = $this->actingAs($karyawan)->post('/karyawan/cart/checkout');

    $response->assertStatus(302);
    $response->assertSessionHasErrors('cart');
});

test('checkout berhasil ketika cart memiliki item', function () {
    /** @var \Tests\TestCase $this */
    $karyawan = createUserWithRole('Karyawan');
    ensureUserHasActiveShift($karyawan);
    $obat = createCartObat();
    addStockToObat($obat, 10, 9000);

    $cart = Cart::create([
        'user_id' => $karyawan->id,
        'is_approved' => false,
    ]);

    CartItem::create([
        'cart_id' => $cart->id,
        'obat_id' => $obat->id,
        'jumlah' => 1,
        'harga_satuan' => 9000,
    ]);

    $response = $this->actingAs($karyawan)->post('/karyawan/cart/checkout');

    $response->assertStatus(302);
    $response->assertRedirect('/karyawan/cart');
    $response->assertSessionHas('success', 'Keranjang dikirim ke kasir untuk approval.');
});

test('karyawan tidak dapat mengakses halaman approval kasir', function () {
    /** @var \Tests\TestCase $this */
    $karyawan = createUserWithRole('Karyawan');
    ensureUserHasActiveShift($karyawan);

    $response = $this->actingAs($karyawan)->get('/kasir/cart/approval');

    $response->assertStatus(403);
});

test('kasir dapat melihat daftar cart yang menunggu approval', function () {
    /** @var \Tests\TestCase $this */
    $karyawan = createUserWithRole('Karyawan');
    ensureUserHasActiveShift($karyawan);
    $kasir = createUserWithRole('Kasir');
    Cart::create([
        'user_id' => $karyawan->id,
        'is_approved' => false,
    ]);

    $response = $this->actingAs($kasir)->get('/kasir/cart/approval');

    $response->assertStatus(200);
    $response->assertViewIs('kasir.cart.approval');
});

test('kasir dapat menolak cart dan menghapusnya', function () {
    /** @var \Tests\TestCase $this */
    $karyawan = createUserWithRole('Karyawan');
    $kasir = createUserWithRole('Kasir');

    $cart = Cart::create([
        'user_id' => $karyawan->id,
        'is_approved' => false,
    ]);

    $response = $this->actingAs($kasir)->post("/kasir/cart/{$cart->id}/reject");

    $response->assertStatus(302);
    $response->assertRedirect('/kasir/cart/approval');
    $response->assertSessionHas('success', 'Cart ditolak.');
    $this->assertDatabaseMissing('carts', ['id' => $cart->id]);
});

test('kasir dapat memproses pembayaran cart tunai', function () {
    /** @var \Tests\TestCase $this */
    $karyawan = createUserWithRole('Karyawan');
    $kasir = createUserWithRole('Kasir');
    $obat = createCartObat();
    addStockToObat($obat, 50, 10000);

    $cart = Cart::create([
        'user_id' => $karyawan->id,
        'is_approved' => false,
    ]);

    CartItem::create([
        'cart_id' => $cart->id,
        'obat_id' => $obat->id,
        'jumlah' => 4,
        'harga_satuan' => 12000,
    ]);

    $totalHarga = 4 * 12000;

    $response = $this->actingAs($kasir)->post('/kasir/cart/process-payment', [
        'cart_id' => $cart->id,
        'metode_pembayaran' => 'tunai',
        'total_bayar' => $totalHarga + 5000,
        'total_harga' => $totalHarga,
    ]);

    $response->assertStatus(302);
    $response->assertRedirect('/kasir/transaksi/riwayat');
    $response->assertSessionHas('success', 'Transaksi berhasil diproses.');

    $this->assertDatabaseHas('transaksi', [
        'total_harga' => $totalHarga,
        'metode_pembayaran' => 'tunai',
    ]);

    $this->assertDatabaseHas('carts', [
        'id' => $cart->id,
        'is_approved' => true,
    ]);
});

function createUserWithRole(string $roleName, array $attributes = []): User
{
    $roleId = Role::where('nama_role', $roleName)->value('id');

    return User::create(array_merge([
        'uuid' => Str::uuid(),
        'role_id' => $roleId,
        'email' => strtolower($roleName) . '_' . Str::random(5) . '@example.com',
        'nama_lengkap' => $roleName . ' User',
        'password' => 'password',
        'is_active' => true,
    ], $attributes));
}

function createCartObat(array $attributes = []): Obat
{
    $kategori = KategoriObat::first() ?? KategoriObat::create([
        'uuid' => Str::uuid(),
        'nama_kategori' => 'Kategori ' . Str::random(5),
    ]);

    $satuan = SatuanObat::first() ?? SatuanObat::create([
        'uuid' => Str::uuid(),
        'nama_satuan' => 'Satuan ' . Str::random(5),
        'faktor_konversi' => 1,
    ]);

    return Obat::create(array_merge([
        'uuid' => Str::uuid(),
        'nama_obat' => 'Obat ' . Str::random(4),
        'kode_obat' => 'OB-' . strtoupper(Str::random(6)),
        'kategori_id' => $kategori->id,
        'satuan_obat_id' => $satuan->id,
        'stok_minimum' => 5,
        'is_racikan' => false,
        'lokasi_rak' => 'A1',
        'barcode' => 'BC-' . Str::random(8),
        'kandungan_id' => [],
    ], $attributes));
}

function addStockToObat(Obat $obat, int $stock, int $hargaJual): StokBatch
{
    return StokBatch::create([
        'uuid' => Str::uuid(),
        'obat_id' => $obat->id,
        'pembelian_id' => null,
        'no_batch' => 'NB-' . Str::random(5),
        'barcode' => 'SB-' . Str::random(5),
        'harga_beli' => $hargaJual - 1000,
        'harga_jual' => $hargaJual,
        'jumlah_masuk' => $stock,
        'sisa_stok' => $stock,
        'tgl_kadaluarsa' => now()->addMonths(6),
    ]);
}

function ensureUserHasActiveShift(User $user): Shift
{
    $day = strtolower(Carbon::now()->locale('id')->dayName);

    return Shift::create([
        'shift_name' => 'Shift ' . Str::random(4),
        'shift_day_of_week' => $day,
        'shift_start' => Carbon::now()->subHours(1)->format('H:i'),
        'shift_end' => Carbon::now()->addHours(1)->format('H:i'),
        'shift_status' => true,
        'user_list' => [$user->id],
    ]);
}

