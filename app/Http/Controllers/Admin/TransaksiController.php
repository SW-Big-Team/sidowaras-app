<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Services\LogMonitorService;

class TransaksiController extends Controller
{
    protected $logMonitor;

    public function __construct(LogMonitorService $logMonitor)
    {
        $this->logMonitor = $logMonitor;
    }

    public function riwayat(Request $request)
    {
        $this->logMonitor->log('view', 'Riwayat Transaksi Viewed');
        $query = Transaksi::with('user');

        // Default filter: 7 hari terakhir jika tidak ada input
        $from = $request->input('from', now()->subDays(6)->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));
        $metode = $request->input('metode');

        // Validasi rentang tanggal maksimal 7 hari
        $startDate = \Carbon\Carbon::parse($from);
        $endDate = \Carbon\Carbon::parse($to);
        
        if ($startDate->diffInDays($endDate) > 6) { // > 6 berarti selisih 7 hari atau lebih (misal tgl 1 s/d 8 = 7 hari selisih = 8 hari total)
            // Kita set max 7 hari total (diffInDays max 6)
            // Jika user pilih > 7 hari, kita reset ke 7 hari dari tanggal 'from' dan beri warning
            $to = $startDate->copy()->addDays(6)->format('Y-m-d');
            session()->flash('warning', 'Rentang tanggal dibatasi maksimal 7 hari. Tanggal akhir telah disesuaikan otomatis.');
        }

        if ($from) {
            $query->whereDate('tgl_transaksi', '>=', $from);
        }

        if ($to) {
            $query->whereDate('tgl_transaksi', '<=', $to);
        }

        if ($metode) {
            $query->where('metode_pembayaran', $metode);
        }

        $transaksis = $query->latest('tgl_transaksi')->paginate(15);

        return view('admin.transaksi.riwayat', compact('transaksis', 'from', 'to', 'metode'));
    }

    public function show(Transaksi $transaksi) // Laravel otomatis cari by id
    {
        $this->logMonitor->log('view', 'Transaksi show viewed');
        $detail = $transaksi->detail()->with('batch.obat')->get();
        return view('admin.transaksi.show', compact('transaksi', 'detail'));
    }
}