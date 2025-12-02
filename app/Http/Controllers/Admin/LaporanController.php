<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pembelian;
use App\Models\StokBatch;
use App\Models\Obat;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Date range logic based on filter type
        $filterType = $request->filter_type ?? 'custom';

        if ($filterType == 'daily') {
            $date = $request->date ? Carbon::parse($request->date) : now();
            $from = $date->copy()->startOfDay();
            $to = $date->copy()->endOfDay();
        } elseif ($filterType == 'monthly') {
            $month = $request->month ? Carbon::parse($request->month) : now();
            $from = $month->copy()->startOfMonth();
            $to = $month->copy()->endOfMonth();
        } elseif ($filterType == 'yearly') {
            $year = $request->year ?? now()->year;
            $from = Carbon::createFromDate($year, 1, 1)->startOfYear();
            $to = Carbon::createFromDate($year, 12, 31)->endOfYear();
        } else {
            // Custom or default
            $from = $request->from ? Carbon::parse($request->from)->startOfDay() : now()->startOfMonth();
            $to = $request->to ? Carbon::parse($request->to)->endOfDay() : now()->endOfDay();
        }

        // Get previous period for comparison
        $daysInPeriod = $from->diffInDays($to);
        $previousFrom = $from->copy()->subDays($daysInPeriod + 1);
        $previousTo = $from->copy()->subDay();

        // SUMMARY STATISTICS
        // Total Revenue (Pendapatan)
        $totalRevenue = Transaksi::whereBetween('tgl_transaksi', [$from, $to])
            ->sum('total_harga');

        $previousRevenue = Transaksi::whereBetween('tgl_transaksi', [$previousFrom, $previousTo])
            ->sum('total_harga');

        $revenueChange = $previousRevenue > 0
            ? (($totalRevenue - $previousRevenue) / $previousRevenue) * 100
            : 0;

        // Total Transactions
        $totalTransactions = Transaksi::whereBetween('tgl_transaksi', [$from, $to])->count();

        $previousTransactions = Transaksi::whereBetween('tgl_transaksi', [$previousFrom, $previousTo])->count();

        $transactionsChange = $previousTransactions > 0
            ? (($totalTransactions - $previousTransactions) / $previousTransactions) * 100
            : 0;

        // Total Purchases (Pembelian)
        $totalPurchases = Pembelian::whereBetween('tgl_pembelian', [$from, $to])
            ->sum('total_harga');

        $previousPurchases = Pembelian::whereBetween('tgl_pembelian', [$previousFrom, $previousTo])
            ->sum('total_harga');

        $purchasesChange = $previousPurchases > 0
            ? (($totalPurchases - $previousPurchases) / $previousPurchases) * 100
            : 0;

        // Total Stock Items
        $totalStock = StokBatch::sum('sisa_stok');

        // PAYMENT METHOD DISTRIBUTION
        $paymentMethods = Transaksi::whereBetween('tgl_transaksi', [$from, $to])
            ->select('metode_pembayaran', DB::raw('count(*) as count'))
            ->groupBy('metode_pembayaran')
            ->get();

        $tunai = $paymentMethods->where('metode_pembayaran', 'tunai')->first()->count ?? 0;
        $nonTunai = $paymentMethods->where('metode_pembayaran', 'non tunai')->first()->count ?? 0;
        $totalPayments = $tunai + $nonTunai;

        $tunaiPercentage = $totalPayments > 0 ? ($tunai / $totalPayments) * 100 : 0;
        $nonTunaiPercentage = $totalPayments > 0 ? ($nonTunai / $totalPayments) * 100 : 0;

        // TOP SELLING MEDICINES
        $topSelling = DetailTransaksi::join('stok_batch', 'detail_transaksi.batch_id', '=', 'stok_batch.id')
            ->join('obat', 'stok_batch.obat_id', '=', 'obat.id')
            ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->whereBetween('transaksi.tgl_transaksi', [$from, $to])
            ->select(
                'obat.nama_obat',
                DB::raw('SUM(detail_transaksi.jumlah) as total_sold'),
                DB::raw('SUM(detail_transaksi.sub_total) as total_revenue')
            )
            ->groupBy('obat.id', 'obat.nama_obat')
            ->orderBy('total_sold', 'DESC')
            ->take(5)
            ->get();

        // LOW STOCK ITEMS - Get medicines where total stock is below minimum
        $lowStock = StokBatch::select('obat_id', DB::raw('SUM(sisa_stok) as total_stock'))
            ->groupBy('obat_id')
            ->with('obat')
            ->get()
            ->filter(function ($batch) {
                return $batch->obat && $batch->total_stock <= $batch->obat->stok_minimum;
            })
            ->sortBy('total_stock')
            ->take(5)
            ->values();

        // CHART DATA - Monthly sales and purchases
        $monthlyData = [];
        $monthlyLabels = [];

        // If period is less than 60 days, show daily data grouped by week
        // Otherwise show monthly data
        if ($daysInPeriod <= 60) {
            // Weekly data for short periods
            for ($i = 0; $i <= $daysInPeriod; $i += 7) {
                $weekStart = $from->copy()->addDays($i);
                $weekEnd = $from->copy()->addDays(min($i + 6, $daysInPeriod));

                $salesData = Transaksi::whereBetween('tgl_transaksi', [$weekStart, $weekEnd])
                    ->sum('total_harga');

                $purchasesData = Pembelian::whereBetween('tgl_pembelian', [$weekStart, $weekEnd])
                    ->sum('total_harga');

                $monthlyData['sales'][] = $salesData / 1000000; // Convert to millions
                $monthlyData['purchases'][] = $purchasesData / 1000000;
                $monthlyLabels[] = $weekStart->format('d M');
            }
        } else {
            // Monthly data for longer periods
            for ($month = $from->copy(); $month <= $to; $month->addMonth()) {
                $monthStart = $month->copy()->startOfMonth();
                $monthEnd = $month->copy()->endOfMonth();

                $salesData = Transaksi::whereBetween('tgl_transaksi', [$monthStart, $monthEnd])
                    ->sum('total_harga');

                $purchasesData = Pembelian::whereBetween('tgl_pembelian', [$monthStart, $monthEnd])
                    ->sum('total_harga');

                $monthlyData['sales'][] = $salesData / 1000000; // Convert to millions
                $monthlyData['purchases'][] = $purchasesData / 1000000;
                $monthlyLabels[] = $month->format('M Y');
            }
        }

        if ($request->export == 'excel') {
            $data = compact(
                'totalRevenue',
                'revenueChange',
                'totalTransactions',
                'transactionsChange',
                'totalPurchases',
                'purchasesChange',
                'totalStock',
                'tunaiPercentage',
                'nonTunaiPercentage',
                'topSelling',
                'lowStock',
                'monthlyData',
                'monthlyLabels',
                'from',
                'to'
            );
            return Excel::download(new LaporanExport($data), 'Laporan_Apotek_' . $from->format('Y-m-d') . '_to_' . $to->format('Y-m-d') . '.xlsx');
        }

        return view('admin.laporan.index', compact(
            'totalRevenue',
            'revenueChange',
            'totalTransactions',
            'transactionsChange',
            'totalPurchases',
            'purchasesChange',
            'totalStock',
            'tunaiPercentage',
            'nonTunaiPercentage',
            'topSelling',
            'lowStock',
            'monthlyData',
            'monthlyLabels',
            'from',
            'to'
        ));
    }
}
