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
<<<<<<< HEAD
                     ->with('user', 'items.obat')
                     ->latest()
                     ->get();
=======
<<<<<<< HEAD
                    ->with('user', 'items.obat')
                    ->latest()
                    ->get();
=======
                     ->with('user', 'items.obat')
                     ->latest()
                     ->get();
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)

        return view('kasir.cart.approval', compact('carts'));
    }

<<<<<<< HEAD
    public function approve(Cart $cart)
=======
<<<<<<< HEAD
    public function showPayment(Cart $cart)
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
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

<<<<<<< HEAD
            // Di CartApprovalController.php → method approve()
=======
            // 2. Kurangi stok & buat detail
=======
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
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
            foreach ($cart->items as $item) {
                $batch = StokBatch::where('obat_id', $item->obat_id)
                                ->where('sisa_stok', '>', 0)
                                ->orderBy('tgl_kadaluarsa')
                                ->first();

                if (!$batch || $batch->sisa_stok < $item->jumlah) {
<<<<<<< HEAD
                    throw new \Exception("Stok tidak mencukupi untuk {$item->obat->nama_obat}");
                }

                // Kurangi stok
=======
<<<<<<< HEAD
                    throw new \Exception("Stok tidak cukup untuk {$item->obat->nama_obat}");
                }

=======
                    throw new \Exception("Stok tidak mencukupi untuk {$item->obat->nama_obat}");
                }

                // Kurangi stok
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
                $stok_sebelum = $batch->sisa_stok;
                $batch->decrement('sisa_stok', $item->jumlah);
                $stok_sesudah = $batch->sisa_stok;

<<<<<<< HEAD
                // Catat log
=======
<<<<<<< HEAD
=======
                // Catat log
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
                LogPerubahanStok::create([
                    'uuid' => \Illuminate\Support\Str::uuid(),
                    'batch_id' => $batch->id,
                    'user_id' => auth()->id(),
                    'stok_sebelum' => $stok_sebelum,
                    'stok_sesudah' => $stok_sesudah,
                    'keterangan' => "Penjualan via transaksi {$transaksi->no_transaksi}",
                ]);

<<<<<<< HEAD
                // Simpan detail transaksi
=======
<<<<<<< HEAD
=======
                // Simpan detail transaksi
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
                DetailTransaksi::create([
                    'uuid' => \Illuminate\Support\Str::uuid(),
                    'transaksi_id' => $transaksi->id,
                    'batch_id' => $batch->id,
                    'jumlah' => $item->jumlah,
                    'harga_saat_transaksi' => $item->harga_satuan,
                    'sub_total' => $item->jumlah * $item->harga_satuan,
                ]);
            }
<<<<<<< HEAD
            // Tandai cart sebagai disetujui
=======
<<<<<<< HEAD

            // 3. Tandai cart sebagai disetujui
=======
            // Tandai cart sebagai disetujui
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
            $cart->update([
                'is_approved' => true,
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

<<<<<<< HEAD
            return redirect()->route('kasir.cart.approval')
                             ->with('success', 'Transaksi berhasil disetujui dan stok diperbarui.');
=======
<<<<<<< HEAD
            return redirect()->route('kasir.transaksi.riwayat')
                            ->with('success', 'Transaksi berhasil diproses.');
=======
            return redirect()->route('kasir.cart.approval')
                             ->with('success', 'Transaksi berhasil disetujui dan stok diperbarui.');
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
        });
    }

    public function reject(Cart $cart)
    {
<<<<<<< HEAD
        $cart->delete(); // atau tandai sebagai rejected jika perlu audit
        return redirect()->route('kasir.cart.approval')
                         ->with('success', 'Cart berhasil ditolak.');
=======
<<<<<<< HEAD
        $cart->delete();
        return redirect()->route('kasir.cart.approval')
                        ->with('success', 'Cart ditolak.');
=======
        $cart->delete(); // atau tandai sebagai rejected jika perlu audit
        return redirect()->route('kasir.cart.approval')
                         ->with('success', 'Cart berhasil ditolak.');
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
    }
}