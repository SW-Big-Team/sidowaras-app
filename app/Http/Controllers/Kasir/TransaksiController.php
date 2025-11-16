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
    public function index()
    {
        $transaksis = Transaksi::with('user')
                                ->where('user_id', auth()->id())
                                ->latest()
                                ->paginate(15);

        return view('kasir.transaksi.riwayat', compact('transaksis'));
    }

    public function show(Transaksi $transaksi) // 
    {
        $detail = $transaksi->detail()->with('batch.obat')->get();
        return view('kasir.transaksi.show', compact('transaksi', 'detail'));
    }
}