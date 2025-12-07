<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Obat;
use App\Models\StokBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        // Ambil cart yang sedang aktif (draft atau pending)
        $cart = Cart::where('user_id', auth()->id())
                    ->whereIn('status', ['draft', 'pending'])
                    ->with('items.obat')
                    ->latest()
                    ->first();

        // Hanya obat non-racikan & stok > 0
        $obats = Obat::where('is_racikan', false)
                     ->whereHas('stokBatches', fn($q) => $q->where('sisa_stok', '>', 0))
                     ->withSum('stokBatches as sisa_stok', 'sisa_stok')
                     ->get();

        return view('karyawan.cart.index', compact('cart', 'obats'));
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $obat = Obat::findOrFail($request->obat_id);

        // Hitung total stok tersedia dari semua batch
        $totalStok = StokBatch::where('obat_id', $obat->id)
                              ->where('sisa_stok', '>', 0)
                              ->sum('sisa_stok');

        if ($totalStok == 0) {
            return back()->withErrors(['obat_id' => 'Stok habis untuk obat ini.']);
        }

        if ($request->jumlah > $totalStok) {
            return back()->withErrors(['jumlah' => "Stok tidak mencukupi. Stok tersedia: {$totalStok}"]);
        }

        // Ambil batch paling awal (FIFO berdasarkan tgl_kadaluarsa) untuk harga referensi
        $batch = StokBatch::where('obat_id', $obat->id)
                          ->where('sisa_stok', '>', 0)
                          ->orderBy('tgl_kadaluarsa')
                          ->first();

        // Buat atau ambil cart aktif (draft)
        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 'draft'],
            ['uuid' => \Illuminate\Support\Str::uuid(), 'is_approved' => false]
        );

        // Simpan harga jual saat ini (snapshot)
        CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'obat_id' => $obat->id],
            ['jumlah' => $request->jumlah, 'harga_satuan' => $batch->harga_jual]
        );

        return back()->with('success', 'Obat berhasil ditambahkan ke keranjang.');
    }

    public function removeItem($id)
    {
        $item = CartItem::findOrFail($id);
        
        // Cek apakah cart masih draft
        if ($item->cart->status !== 'draft') {
            return back()->withErrors(['error' => 'Tidak dapat menghapus item dari keranjang yang sudah dikirim.']);
        }
        
        $item->delete();
        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        // Tidak perlu validasi metode_pembayaran - akan diisi oleh Kasir saat approval
        $cart = Cart::where('user_id', auth()->id())
                    ->where('status', 'draft')
                    ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->withErrors(['cart' => 'Keranjang kosong.']);
        }

        // Ubah status menjadi pending - menunggu approval kasir
        $cart->update(['status' => 'pending']);

        return redirect()->route('karyawan.cart.index')
                         ->with('success', 'Keranjang berhasil dikirim ke kasir untuk approval.');
    }

    public function show(Cart $cart)
    {
        // Ensure the cart belongs to the authenticated user
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        return view('karyawan.cart.show', compact('cart'));
    }
}