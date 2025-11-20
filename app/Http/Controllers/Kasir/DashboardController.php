<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Transaksi;
use App\Models\Obat;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Pending cart approvals
        $pendingCartsCount = Cart::where('is_approved', false)
            ->orWhereNull('is_approved')
            ->count();

        // Today's transactions
        $todayTransactionsCount = Transaksi::whereDate('created_at', Carbon::today())
            ->count();

        // Today's sales
        $todaySales = Transaksi::whereDate('created_at', Carbon::today())
            ->sum('total_bayar');

        // Low stock items
        $lowStockCount = Obat::whereColumn('stok_tersedia', '<=', 'stok_minimum')
            ->count();

        // Recent pending carts
        $pendingCarts = Cart::with(['user', 'items.obat'])
            ->where(function($query) {
                $query->where('is_approved', false)
                    ->orWhereNull('is_approved');
            })
            ->latest()
            ->take(5)
            ->get();

        // Low stock items details
        $lowStockItems = Obat::whereColumn('stok_tersedia', '<=', 'stok_minimum')
            ->orderBy('stok_tersedia', 'asc')
            ->take(5)
            ->get();

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
