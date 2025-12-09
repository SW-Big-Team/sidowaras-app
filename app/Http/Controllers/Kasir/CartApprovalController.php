<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DetailTransaksi;
use App\Models\LogPerubahanStok;
use App\Models\StokBatch;
use App\Models\Transaksi;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartApprovalController extends Controller
{
    public function index()
    {
        $carts = Cart::where('status', 'pending')
            ->with('user', 'items.obat')
            ->latest()
            ->get();

        return view('kasir.cart.approval', compact('carts'));
    }

    public function showPayment(Cart $cart)
    {
        if ($cart->isApproved()) {
            return redirect()->route('kasir.cart.approval')->withErrors('Cart sudah disetujui.');
        }

        $totalHarga = $cart->items->sum(fn($i) => $i->jumlah * $i->harga_satuan);
        return view('kasir.cart.payment', compact('cart', 'totalHarga'));
    }

    public function processPayment(Request $request)
    {
        $cart = Cart::findOrFail($request->cart_id);

        // Recalculate total based on submitted prices
        $prices = $request->input('prices', []);
        $calculatedTotal = 0;
        foreach ($cart->items as $item) {
            $price = isset($prices[$item->id]) ? str_replace('.', '', $prices[$item->id]) : $item->harga_satuan;
            $calculatedTotal += $item->jumlah * $price;
        }

        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'metode_pembayaran' => 'required|in:tunai,non tunai',
            'total_bayar' => 'nullable|numeric|min:' . $calculatedTotal,
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($cart, $request, $calculatedTotal, $prices) {
            // 1. Buat transaksi
            $transaksi = Transaksi::create([
                'uuid' => \Illuminate\Support\Str::uuid(),
                'no_transaksi' => 'TRX-' . now()->format('ymd') . '-' . str_pad($cart->id, 5, '0', STR_PAD_LEFT),
                'user_id' => auth()->id(),
                'total_harga' => $calculatedTotal,
                'total_bayar' => $request->metode_pembayaran === 'tunai' ? $request->total_bayar : $calculatedTotal,
                'kembalian' => $request->metode_pembayaran === 'tunai' ? ($request->total_bayar - $calculatedTotal) : 0,
                'metode_pembayaran' => $request->metode_pembayaran,
                'tgl_transaksi' => now(),
                'keterangan' => $request->keterangan,
            ]);

            // 2. Kurangi stok & buat detail (dengan FIFO)
            foreach ($cart->items as $item) {
                $sisaJumlah = $item->jumlah;
                $hargaSatuan = isset($prices[$item->id]) ? $prices[$item->id] : $item->harga_satuan;

                // Ambil semua batch yang ada stok, urutkan FIFO (tgl_kadaluarsa paling awal dulu)
                $batches = StokBatch::where('obat_id', $item->obat_id)
                    ->where('sisa_stok', '>', 0)
                    ->orderBy('tgl_kadaluarsa')
                    ->get();

                // Hitung total stok tersedia
                $totalStokTersedia = $batches->sum('sisa_stok');

                if ($totalStokTersedia < $item->jumlah) {
                    throw new \Exception("Stok tidak cukup untuk {$item->obat->nama_obat}. Tersedia: {$totalStokTersedia}, Dibutuhkan: {$item->jumlah}");
                }

                // Kurangi stok dari batch satu per satu (FIFO)
                foreach ($batches as $batch) {
                    if ($sisaJumlah <= 0)
                        break;

                    $jumlahAmbil = min($sisaJumlah, $batch->sisa_stok);

                    $stok_sebelum = $batch->sisa_stok;
                    $batch->decrement('sisa_stok', $jumlahAmbil);
                    $stok_sesudah = $batch->sisa_stok;

                    LogPerubahanStok::create([
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'batch_id' => $batch->id,
                        'user_id' => auth()->id(),
                        'stok_sebelum' => $stok_sebelum,
                        'stok_sesudah' => $stok_sesudah,
                        'keterangan' => "Penjualan via transaksi {$transaksi->no_transaksi}",
                    ]);

                    DetailTransaksi::create([
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'transaksi_id' => $transaksi->id,
                        'batch_id' => $batch->id,
                        'jumlah' => $jumlahAmbil,
                        'harga_saat_transaksi' => $hargaSatuan,
                        'sub_total' => $jumlahAmbil * $hargaSatuan,
                    ]);

                    $sisaJumlah -= $jumlahAmbil;
                }
            }

            // 3. Tandai cart sebagai disetujui
            $cart->update([
                'status' => 'approved',
                'is_approved' => true,
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            // Generate notification for cart creator
            app(NotificationService::class)->notifyCartApproved($cart);

            // Update system notifications (stok dan kadaluarsa mungkin berubah)
            app(NotificationService::class)->generateSystemNotifications();

            return redirect()->route('kasir.transaksi.riwayat')
                ->with('success', 'Transaksi berhasil diproses.');
        });
    }

    public function reject(Cart $cart)
    {
        // Update status menjadi rejected
        $cart->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Generate notification for cart creator
        app(NotificationService::class)->notifyCartRejected($cart);

        // Update system notifications
        app(NotificationService::class)->generateSystemNotifications();

        return redirect()->route('kasir.cart.approval')
            ->with('success', 'Cart berhasil ditolak.');
    }
}