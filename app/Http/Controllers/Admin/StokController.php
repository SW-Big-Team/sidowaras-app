<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $obats = Obat::with('kategori', 'satuan', 'stokBatches')
                     ->latest()
                     ->paginate(15);

        return view('admin.stok.index', compact('obats'));
    }
}