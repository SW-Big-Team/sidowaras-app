<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $transaksis = Transaksi::where('user_id', Auth::id())
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('karyawan.transaksi.index', compact('transaksis'));
    }

    public function show(Transaksi $transaksi)
    {
        // Ensure the transaction belongs to the authenticated user
        if ($transaksi->user_id !== Auth::id()) {
            abort(403);
        }

        return view('karyawan.transaksi.show', compact('transaksi'));
    }
}
