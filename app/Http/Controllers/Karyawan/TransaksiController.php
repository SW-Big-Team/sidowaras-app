<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\LogMonitorService;

class TransaksiController extends Controller
{
    protected $logMonitor;

    public function __construct(LogMonitorService $logMonitor)
    {
        $this->logMonitor = $logMonitor;
    }

    public function index(Request $request)
    {
        $this->logMonitor->log('view', 'Riwayat Transaksi Viewed');
        $query = Transaksi::where('user_id', Auth::id());

        // Search by transaction number
        if ($request->filled('search')) {
            $query->where('no_transaksi', 'like', '%' . $request->search . '%');
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by payment method
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        $perPage = $request->input('per_page', 10);
        $transaksis = $query->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('karyawan.transaksi.index', compact('transaksis'));
    }

    public function show(Transaksi $transaksi)
    {
        $this->logMonitor->log('view', 'Transaksi Detail Viewed');
        // Ensure the transaction belongs to the authenticated user
        if ($transaksi->user_id !== Auth::id()) {
            abort(403);
        }

        return view('karyawan.transaksi.show', compact('transaksi'));
    }
}
