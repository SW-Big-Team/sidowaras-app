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
        $cart = Cart::where('user_id', auth()->id())
                    ->where('is_approved', false)
                    ->with('items.obat')
                    ->first();

        // Hanya obat non-racikan & stok > 0
        $obats = Obat::where('is_racikan', false)
                     ->whereHas('stokBatches', fn($q) => $q->where('sisa_stok', '>', 0))
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

        // Ambil batch paling awal (FIFO berdasarkan tgl_kadaluarsa)
        $batch = StokBatch::where('obat_id', $obat->id)
                          ->where('sisa_stok', '>', 0)
                          ->orderBy('tgl_kadaluarsa')
                          ->first();

        if (!$batch) {
            return back()->withErrors(['obat_id' => 'Stok habis untuk obat ini.']);
        }

        if ($request->jumlah > $batch->sisa_stok) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi.']);
        }

        // Buat atau ambil cart aktif
        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'is_approved' => false],
            ['uuid' => \Illuminate\Support\Str::uuid()]
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
        $item->delete();
        return back();
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:tunai,non tunai',
        ]);

        $cart = Cart::where('user_id', auth()->id())
                    ->where('is_approved', false)
                    ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->withErrors(['cart' => 'Keranjang kosong.']);
        }

        $cart->update(['metode_pembayaran' => $request->metode_pembayaran]);

        return redirect()->route('karyawan.cart.index')
                         ->with('success', 'Keranjang dikirim ke kasir untuk approval.');
    }
}