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
                               ->latest()
                               ->paginate(10);

        return view('kasir.transaksi.riwayat', compact('transaksis'));
    }

    /**
     * Menampilkan detail transaksi lengkap.
     */
    public function show(Transaksi $transaksi)
    {
        $detail = $transaksi->detail()->with('batch.obat')->get();
        return view('kasir.transaksi.detail', compact('transaksi', 'detail'));
    }
}