<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Obat;
use App\Models\StokBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\LogMonitorService;
class CartController extends Controller
{
    protected $logMonitor;

    public function __construct(LogMonitorService $logMonitor)
    {
        $this->logMonitor = $logMonitor;
    }

    public function index()
    {
        $this->logMonitor->log('view', 'Cart Dashboard Viewed');
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
        DB::beginTransaction();
        try{
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

            DB::commit();
            $this->logMonitor->logCreate($cart, 'Item added to Cart');

            return back()->with('success', 'Obat berhasil ditambahkan ke keranjang.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logMonitor->logError('addItem', $e->getMessage(), 'Add Item to Cart Failed', $request);
            return back()->withErrors(['error' => 'Gagal menambahkan obat ke keranjang: ' . $e->getMessage()]);
        }
    }

    public function removeItem($id)
    {
        DB::beginTransaction();
        try{
            $item = CartItem::findOrFail($id);
            
            // Cek apakah cart masih draft
            if ($item->cart->status !== 'draft') {
                return back()->withErrors(['error' => 'Tidak dapat menghapus item dari keranjang yang sudah dikirim.']);
            }
            
            $item->delete();

            DB::commit();
            $this->logMonitor->logDelete($item, 'Item removed from Cart');

            return back()->with('success', 'Item berhasil dihapus dari keranjang.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logMonitor->logError('removeItem', $e->getMessage(), 'Remove Item from Cart Failed', $item);
            return back()->withErrors(['error' => 'Gagal menghapus item dari keranjang: ' . $e->getMessage()]);
        }
    }

    public function checkout(Request $request)
    {
        DB::beginTransaction();
        try{
            // Tidak perlu validasi metode_pembayaran - akan diisi oleh Kasir saat approval
            $cart = Cart::where('user_id', auth()->id())
                        ->where('status', 'draft')
                        ->first();

            if (!$cart || $cart->items->isEmpty()) {
                return back()->withErrors(['cart' => 'Keranjang kosong.']);
            }

            // Ubah status menjadi pending - menunggu approval kasir
            $cart->update(['status' => 'pending']);

            DB::commit();
            $this->logMonitor->logUpdate($cart, 'Cart status updated to pending approval');

            return redirect()->route('karyawan.cart.index')
                            ->with('success', 'Keranjang berhasil dikirim ke kasir untuk approval.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logMonitor->logError('checkout', $e->getMessage(), 'Checkout Failed', $request);
            return back()->withErrors(['error' => 'Gagal mengirim keranjang: ' . $e->getMessage()]);
        }
    }

    public function show(Cart $cart)
    {
        $this->logMonitor->log('view', 'Cart Detail Viewed');
        // Ensure the cart belongs to the authenticated user
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        return view('karyawan.cart.show', compact('cart'));
    }
}