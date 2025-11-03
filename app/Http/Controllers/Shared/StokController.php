<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $obats = Obat::with('kategori', 'satuan', 'stokBatches')
                     ->whereHas('stokBatches', fn($q) => $q->where('sisa_stok', '>', 0))
                     ->latest()
                     ->paginate(15);

        return view('shared.stok.index', compact('obats'));
    }
}