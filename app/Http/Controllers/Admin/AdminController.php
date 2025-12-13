<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\StokBatch;
use App\Models\Obat;
use App\Models\StockOpname;
use App\Models\DetailTransaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\LogMonitorService;

class AdminController extends Controller
{
    protected $logMonitor;

    public function __construct(LogMonitorService $logMonitor)
    {
        $this->logMonitor = $logMonitor;
    }

    public function index()
    {
        $this->logMonitor->log('view', 'Admin Dashboard Viewed');
        
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // --- Key Metrics ---

        // 1. Penjualan Hari Ini
        $salesToday = Transaksi::whereDate('tgl_transaksi', $today)->sum('total_bayar');
        $salesYesterday = Transaksi::whereDate('tgl_transaksi', $yesterday)->sum('total_bayar');
        
        $salesGrowthToday = 0;
        if ($salesYesterday > 0) {
            $salesGrowthToday = (($salesToday - $salesYesterday) / $salesYesterday) * 100;
        } elseif ($salesToday > 0) {
            $salesGrowthToday = 100;
        }

        // 2. Penjualan Bulan Ini
        $salesMonth = Transaksi::whereBetween('tgl_transaksi', [$startOfMonth, Carbon::now()])->sum('total_bayar');
        $salesLastMonth = Transaksi::whereBetween('tgl_transaksi', [$startOfLastMonth, $endOfLastMonth])->sum('total_bayar');

        $salesGrowthMonth = 0;
        if ($salesLastMonth > 0) {
            $salesGrowthMonth = (($salesMonth - $salesLastMonth) / $salesLastMonth) * 100;
        } elseif ($salesMonth > 0) {
            $salesGrowthMonth = 100;
        }

        // 3. Total Pengguna
        $totalUsers = User::count();
        $usersByRole = User::with('role')
            ->get()
            ->groupBy('role.nama_role')
            ->map(fn($users) => $users->count());
        
        $adminCount = $usersByRole['Admin'] ?? 0;
        $kasirCount = $usersByRole['Kasir'] ?? 0;
        $karyawanCount = $usersByRole['Karyawan'] ?? 0;

        // 4. Nilai Stok (Inventory Value)
        // Asumsi: Nilai stok = sum(sisa_stok * harga_beli) dari semua batch aktif
        $inventoryValue = StokBatch::where('sisa_stok', '>', 0)
            ->select(DB::raw('SUM(sisa_stok * harga_beli) as total_value'))
            ->value('total_value') ?? 0;

        // --- Monitoring Transaksi ---
        $todayTransactionsCount = Transaksi::whereDate('tgl_transaksi', $today)->count();
        // Cart pending logic would go here if Cart model has status, assuming placeholder for now or checking Cart model
        // Assuming Cart model exists based on file list, but logic might need adjustment. 
        // For now, let's use a placeholder or count Carts created today if possible.
        // Checking Cart model file earlier: Cart.php exists.
        $pendingCartsCount = \App\Models\Cart::count(); // Simplification: count all carts as pending for now

        // Stok Alerts
        $minStockCount = Obat::whereColumn('stok_minimum', '>=', DB::raw('(SELECT COALESCE(SUM(sisa_stok), 0) FROM stok_batch WHERE stok_batch.obat_id = obat.id)'))->count();
        
        $expiredCount = StokBatch::where('sisa_stok', '>', 0)
            ->where('tgl_kadaluarsa', '<=', Carbon::now())
            ->count();

        $recentTransactions = Transaksi::with(['user'])
            ->whereDate('tgl_transaksi', $today)
            ->latest('tgl_transaksi')
            ->take(5)
            ->get();

        // --- Financial Reports ---
        // Revenue = Sales Month (calculated above)
        
        // HPP (Harga Pokok Penjualan) Bulan Ini
        // Join DetailTransaksi -> Transaksi to filter by date
        // DetailTransaksi has batch_id, we need original buy price from batch?
        // DetailTransaksi table has 'jumlah'. We need to multiply by batch's buy price.
        // But DetailTransaksi doesn't store buy price snapshot. We must link to StokBatch.
        $hppMonth = DetailTransaksi::whereHas('transaksi', function($q) use ($startOfMonth) {
                $q->whereBetween('tgl_transaksi', [$startOfMonth, Carbon::now()]);
            })
            ->join('stok_batch', 'detail_transaksi.batch_id', '=', 'stok_batch.id')
            ->select(DB::raw('SUM(detail_transaksi.jumlah * stok_batch.harga_beli) as total_hpp'))
            ->value('total_hpp') ?? 0;

        $netProfit = $salesMonth - $hppMonth;
        $profitMargin = $salesMonth > 0 ? ($netProfit / $salesMonth) * 100 : 0;

        // --- Stock Reports ---
        // Expired & Min Stock calculated above for cards, reused here.
        $pendingOpnameCount = StockOpname::where('status', 'Pending')->count(); // Assuming 'status' column exists

        // --- User Activity ---
        $roleFilter = request('role');
        
        $trxQuery = Transaksi::with('user.role')->latest('tgl_transaksi');
        $opnameQuery = StockOpname::with('creator.role')->latest('created_at');

        if ($roleFilter && $roleFilter !== 'Semua Role') {
            $trxQuery->whereHas('user.role', fn($q) => $q->where('nama_role', $roleFilter));
            $opnameQuery->whereHas('creator.role', fn($q) => $q->where('nama_role', $roleFilter));
        }

        $trxActivities = $trxQuery->take(5)
            ->get()
            ->toBase()
            ->map(function($trx) {
                return [
                    'user' => $trx->user,
                    'action' => 'Melakukan transaksi #' . $trx->no_transaksi,
                    'time' => $trx->tgl_transaksi,
                    'type' => 'success', // badge color
                    'status' => 'Sukses'
                ];
            });

        $opnameActivities = $opnameQuery->take(5)
            ->get()
            ->toBase()
            ->map(function($op) {
                return [
                    'user' => $op->creator,
                    'action' => 'Submit stock opname',
                    'time' => $op->created_at,
                    'type' => 'info',
                    'status' => $op->status ?? 'Submitted'
                ];
            });
        
        $activities = $trxActivities->merge($opnameActivities)->sortByDesc('time')->take(10);

        return view('admin.index', compact(
            'salesToday', 'salesGrowthToday',
            'salesMonth', 'salesGrowthMonth',
            'totalUsers', 'adminCount', 'kasirCount', 'karyawanCount',
            'inventoryValue',
            'todayTransactionsCount', 'pendingCartsCount', 'minStockCount', 'expiredCount',
            'recentTransactions',
            'hppMonth', 'netProfit', 'profitMargin',
            'pendingOpnameCount',
            'activities'
        ));
    }
}
