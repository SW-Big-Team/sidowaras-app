<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function riwayat()
    {
        $transaksis = Transaksi::with('user')
                               ->latest()
                               ->paginate(15);

        return view('admin.transaksi.riwayat', compact('transaksis'));
    }

<<<<<<< HEAD
    public function show(Transaksi $transaksi) // Laravel otomatis cari by id
    {
        $detail = $transaksi->detail()->with('batch.obat')->get();
=======
    public function show($uuid)
    {
        $transaksi = Transaksi::where('uuid', $uuid)->firstOrFail();
        $detail = $transaksi->detail()->with('batch.obat')->get();

<<<<<<< HEAD
>>>>>>> 63e5397 (Add new views and controllers for Stok and Transaksi management, update relationships in models, and enhance kategori forms.)
=======
>>>>>>> e04ebff (Add new views and controllers for Stok and Transaksi management, update relationships in models, and enhance kategori forms.)
>>>>>>> 6334068 (Add new views and controllers for Stok and Transaksi management, update relationships in models, and enhance kategori forms.)
        return view('admin.transaksi.show', compact('transaksi', 'detail'));
    }
}