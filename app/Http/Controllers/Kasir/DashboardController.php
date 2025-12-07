<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Transaksi;
use App\Models\Obat;
use App\Models\StokBatch;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Pending cart approvals
        $pendingCartsCount = Cart::where('status', 'pending')->count();

        // Today's transactions
        $todayTransactionsCount = Transaksi::whereDate('created_at', Carbon::today())
            ->count();

        // Today's sales
        $todaySales = Transaksi::whereDate('created_at', Carbon::today())
            ->sum('total_bayar');

        // Low stock count - obat dengan total stok < stok_minimum
        $lowStockCount = Obat::whereHas('stokBatches')
            ->get()
            ->filter(function($obat) {
                $totalStok = $obat->stokBatches()->sum('sisa_stok');
                return $totalStok < $obat->stok_minimum;
            })
            ->count();

        // Recent pending carts
        $pendingCarts = Cart::with(['user', 'items.obat'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Low stock items details - obat dengan total stok < stok_minimum
        $lowStockItems = Obat::with('stokBatches')
            ->get()
            ->map(function($obat) {
                $obat->total_stok = $obat->stokBatches->sum('sisa_stok');
                return $obat;
            })
            ->filter(function($obat) {
                return $obat->total_stok < $obat->stok_minimum;
            })
            ->sortBy('total_stok')
            ->take(5)
            ->values();

        return view('kasir.index', compact(
            'pendingCartsCount',
            'todayTransactionsCount',
            'todaySales',
            'lowStockCount',
            'pendingCarts',
            'lowStockItems'
        ));
    }
}
