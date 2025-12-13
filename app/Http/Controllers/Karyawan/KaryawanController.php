<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\StokBatch;
use App\Models\StockOpname;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\LogMonitorService;

class KaryawanController extends Controller
{
    protected $logMonitor;

    public function __construct(LogMonitorService $logMonitor)
    {
        $this->logMonitor = $logMonitor;
    }

    public function index()
    {
        $this->logMonitor->log('view', 'Karyawan Dashboard Viewed');
        $user = Auth::user();
        $today = Carbon::today();

        // 1. Active Carts (Pending/Draft)
        // Assuming carts not approved are active/pending
        $activeCartCount = Cart::where('user_id', $user->id)
            ->where('is_approved', false)
            ->count();

        // 2. Stock Opname Progress
        // Find active stock opname for today or the most recent open one
        $stockOpname = StockOpname::where('status', '!=', 'approved')
            ->where('status', '!=', 'rejected')
            ->latest()
            ->first();

        $stockOpnameProgress = 0;
        $stockOpnameTotal = 0;
        $stockOpnameChecked = 0;

        if ($stockOpname) {
            // Assuming we want to check all active stock batches
            // This logic might need adjustment based on business rules
            // For now, let's use the details count vs total active batches as a proxy
            $stockOpnameChecked = $stockOpname->details()->count();
            $stockOpnameTotal = StokBatch::where('sisa_stok', '>', 0)->count(); // Total items to check
            
            if ($stockOpnameTotal > 0) {
                $stockOpnameProgress = round(($stockOpnameChecked / $stockOpnameTotal) * 100, 1);
            }
        }

        // 3. Expired Items
        $expiredItemsCount = StokBatch::where('tgl_kadaluarsa', '<', $today)
            ->where('sisa_stok', '>', 0)
            ->count();

        // 4. Total Transactions (Shift/Today)
        $totalTransactions = Transaksi::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->count();

        // 5. Recent Activity
        $recentCarts = Cart::where('user_id', $user->id)
            ->with('items')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($cart) {
                return [
                    'type' => 'cart',
                    'id' => $cart->id,
                    'uuid' => $cart->uuid,
                    'status' => $cart->is_approved ? 'Approved' : 'Pending',
                    'total' => $cart->items->sum(fn($item) => $item->harga * $item->qty), // Calculate total manually if not stored
                    'items_count' => $cart->items->count(),
                    'date' => $cart->created_at,
                ];
            });

        $recentTransactions = Transaksi::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($trx) {
                return [
                    'type' => 'transaction',
                    'id' => $trx->id,
                    'uuid' => $trx->uuid,
                    'status' => 'Completed',
                    'total' => $trx->total_bayar,
                    'items_count' => $trx->detail->count(),
                    'date' => $trx->created_at,
                ];
            });

        $recentActivities = $recentCarts->merge($recentTransactions)
            ->sortByDesc('date')
            ->take(5);

        return view('karyawan.index', compact(
            'activeCartCount',
            'stockOpnameProgress',
            'stockOpnameTotal',
            'stockOpnameChecked',
            'expiredItemsCount',
            'totalTransactions',
            'recentActivities'
        ));
    }
}
