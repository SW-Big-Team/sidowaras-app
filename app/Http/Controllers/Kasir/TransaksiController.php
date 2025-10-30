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
<<<<<<< HEAD
                               ->latest()
                               ->paginate(10);
=======
<<<<<<< HEAD
                                ->where('user_id', auth()->id())
                                ->latest()
                                ->paginate(15);
=======
                               ->latest()
                               ->paginate(10);
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)

        return view('kasir.transaksi.riwayat', compact('transaksis'));
    }

<<<<<<< HEAD
    /**
     * Menampilkan detail transaksi lengkap.
     */
    public function show(Transaksi $transaksi)
    {
        $detail = $transaksi->detail()->with('batch.obat')->get();
        return view('kasir.transaksi.detail', compact('transaksi', 'detail'));
=======
<<<<<<< HEAD
    public function show(Transaksi $transaksi) // 
    {
        $detail = $transaksi->detail()->with('batch.obat')->get();
        return view('kasir.transaksi.show', compact('transaksi', 'detail'));
=======
    /**
     * Menampilkan detail transaksi lengkap.
     */
    public function show(Transaksi $transaksi)
    {
        $detail = $transaksi->detail()->with('batch.obat')->get();
        return view('kasir.transaksi.detail', compact('transaksi', 'detail'));
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
    }
}