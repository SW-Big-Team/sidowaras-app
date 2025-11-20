<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Menampilkan daftar riwayat transaksi.
     */
    public function index(Request $request)
    {
        $query = Transaksi::with('user')
                          ->where('user_id', auth()->id());

        // Search by transaction number
        if ($request->filled('search')) {
            $query->where('no_transaksi', 'like', '%' . $request->search . '%');
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('tgl_transaksi', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tgl_transaksi', '<=', $request->end_date);
        }

        // Filter by payment method
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        $transaksis = $query->latest()->paginate(15)->withQueryString();

        return view('kasir.transaksi.riwayat', compact('transaksis'));
    }

    public function show(Transaksi $transaksi) // 
    {
        $detail = $transaksi->detail()->with('batch.obat')->get();
        return view('kasir.transaksi.show', compact('transaksi', 'detail'));
    }
}