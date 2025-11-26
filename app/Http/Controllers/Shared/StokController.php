<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $query = Obat::with('kategori', 'satuan', 'stokBatches')
                     ->whereHas('stokBatches', fn($q) => $q->where('sisa_stok', '>', 0));

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('kode_obat', 'like', "%{$search}%");
            });
        }

        $obats = $query->latest()->paginate(15);

        return view('shared.stok.index', compact('obats'));
    }
}