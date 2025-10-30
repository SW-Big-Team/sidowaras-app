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
<<<<<<< HEAD
                               ->latest()
                               ->paginate(10);
=======
=======
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
<<<<<<< HEAD
                                ->where('user_id', auth()->id())
                                ->latest()
                                ->paginate(15);
=======
                               ->latest()
                               ->paginate(10);
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
<<<<<<< HEAD
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
=======
=======
                               ->latest()
                               ->paginate(10);
>>>>>>> f5d5d3d (Add Cart functionality and update Bootstrap version)
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)

        return view('kasir.transaksi.riwayat', compact('transaksis'));
    }

<<<<<<< HEAD
<<<<<<< HEAD
    /**
     * Menampilkan detail transaksi lengkap.
     */
    public function show(Transaksi $transaksi)
    {
        $detail = $transaksi->detail()->with('batch.obat')->get();
        return view('kasir.transaksi.detail', compact('transaksi', 'detail'));
=======
=======
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
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
<<<<<<< HEAD
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
=======
=======
    /**
     * Menampilkan detail transaksi lengkap.
     */
    public function show(Transaksi $transaksi)
    {
        $detail = $transaksi->detail()->with('batch.obat')->get();
        return view('kasir.transaksi.detail', compact('transaksi', 'detail'));
>>>>>>> f5d5d3d (Add Cart functionality and update Bootstrap version)
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
    }
}