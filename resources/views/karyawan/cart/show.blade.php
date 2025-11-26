@extends('layouts.karyawan.app')

@section('title', 'Detail Cart')
@section('breadcrumb', 'Dashboard / Cart / Detail')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Cart: {{ substr($cart->uuid, 0, 8) }}</h5>
                    <a href="{{ route('karyawan.dashboard') }}" class="btn btn-outline-secondary btn-sm mb-0">Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-6">
                            <h6 class="text-sm mb-1">Tanggal Dibuat</h6>
                            <p class="text-sm font-weight-bold">{{ $cart->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div class="col-6 text-end">
                            <h6 class="text-sm mb-1">Status</h6>
                            <span class="badge bg-gradient-{{ $cart->is_approved ? 'success' : 'warning' }}">
                                {{ $cart->is_approved ? 'Approved' : 'Pending' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-end">Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-end">Qty</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->obat->nama_obat ?? 'Unknown' }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="text-end">
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->jumlah }}</p>
                                    </td>
                                    <td class="text-end">
                                        <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><h6 class="mb-0">Total Estimasi</h6></td>
                                    <td class="text-end"><h6 class="mb-0">Rp {{ number_format($cart->items->sum(fn($i) => $i->harga_satuan * $i->jumlah), 0, ',', '.') }}</h6></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
