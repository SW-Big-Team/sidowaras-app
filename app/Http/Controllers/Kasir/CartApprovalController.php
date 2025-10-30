<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DetailTransaksi;
use App\Models\LogPerubahanStok;
use App\Models\StokBatch;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartApprovalController extends Controller
{
    public function index()
    {
        $carts = Cart::where('is_approved', false)
                     ->with('user', 'items.obat')
                     ->latest()
                     ->get();

        return view('kasir.cart.approval', compact('carts'));
    }

    public function approve(Cart $cart)
    {
        return DB::transaction(function () use ($cart) {
            // Validasi: pastikan cart belum disetujui
            if ($cart->is_approved) {
                return back()->withErrors(['cart' => 'Cart sudah disetujui sebelumnya.']);
            }

            // Hitung total harga
            $totalHarga = $cart->items->sum(fn($item) => $item->jumlah * $item->harga_satuan);

            // Buat transaksi
            $transaksi = Transaksi::create([
                'uuid' => \Illuminate\Support\Str::uuid(),
                'no_transaksi' => 'TRX-' . now()->format('Ymd') . '-' . str_pad($cart->id, 5, '0', STR_PAD_LEFT),
                'user_id' => auth()->id(),
                'total_harga' => $totalHarga,
                'total_bayar' => 0, // Akan diisi saat pembayaran (opsional, bisa diisi nanti)
                'kembalian' => 0,
                'tgl_transaksi' => now(),
            ]);

            // Di CartApprovalController.php → method approve()
            foreach ($cart->items as $item) {
                $batch = StokBatch::where('obat_id', $item->obat_id)
                                ->where('sisa_stok', '>', 0)
                                ->orderBy('tgl_kadaluarsa')
                                ->first();

                if (!$batch || $batch->sisa_stok < $item->jumlah) {
                    throw new \Exception("Stok tidak mencukupi untuk {$item->obat->nama_obat}");
                }

                // Kurangi stok
                $stok_sebelum = $batch->sisa_stok;
                $batch->decrement('sisa_stok', $item->jumlah);
                $stok_sesudah = $batch->sisa_stok;

                // Catat log
                LogPerubahanStok::create([
                    'uuid' => \Illuminate\Support\Str::uuid(),
                    'batch_id' => $batch->id,
                    'user_id' => auth()->id(),
                    'stok_sebelum' => $stok_sebelum,
                    'stok_sesudah' => $stok_sesudah,
                    'keterangan' => "Penjualan via transaksi {$transaksi->no_transaksi}",
                ]);

                // Simpan detail transaksi
                DetailTransaksi::create([
                    'uuid' => \Illuminate\Support\Str::uuid(),
                    'transaksi_id' => $transaksi->id,
                    'batch_id' => $batch->id,
                    'jumlah' => $item->jumlah,
                    'harga_saat_transaksi' => $item->harga_satuan,
                    'sub_total' => $item->jumlah * $item->harga_satuan,
                ]);
            }
            // Tandai cart sebagai disetujui
            $cart->update([
                'is_approved' => true,
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            return redirect()->route('kasir.cart.approval')
                             ->with('success', 'Transaksi berhasil disetujui dan stok diperbarui.');
        });
    }

    public function reject(Cart $cart)
    {
        $cart->delete(); // atau tandai sebagai rejected jika perlu audit
        return redirect()->route('kasir.cart.approval')
                         ->with('success', 'Cart berhasil ditolak.');
    }
}