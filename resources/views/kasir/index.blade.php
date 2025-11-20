@extends('layouts.kasir.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h4 class="text-dark font-weight-bold mb-1">Dashboard Kasir</h4>
        <p class="text-sm text-muted mb-4">Selamat datang di panel kasir Sidowaras</p>
    </div>
</div>

<!-- Metrics Cards Row -->
<div class="row">
    <!-- Pending Cart Approvals -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold opacity-7">Cart Menunggu</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $pendingCartsCount }}
                                <span class="text-warning text-sm ms-1">approval</span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-warning shadow text-center border-radius-md">
                            <i class="material-symbols-rounded text-white opacity-10" style="font-size: 2rem;">pending_actions</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Transactions -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold opacity-7">Transaksi Hari Ini</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $todayTransactionsCount }}
                                <span class="text-success text-sm ms-1">transaksi</span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-success shadow text-center border-radius-md">
                            <i class="material-symbols-rounded text-white opacity-10" style="font-size: 2rem;">receipt_long</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Sales -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold opacity-7">Penjualan Hari Ini</p>
                            <h5 class="font-weight-bolder mb-0">
                                Rp {{ number_format($todaySales, 0, ',', '.') }}
                                <span class="text-info text-sm ms-1">total</span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-info shadow text-center border-radius-md">
                            <i class="material-symbols-rounded text-white opacity-10" style="font-size: 2rem;">payments</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alerts -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold opacity-7">Stok Minimum</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $lowStockCount }}
                                <span class="text-danger text-sm ms-1">item</span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-danger shadow text-center border-radius-md">
                            <i class="material-symbols-rounded text-white opacity-10" style="font-size: 2rem;">inventory</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions & Notifications Row -->
<div class="row mt-4">
    <!-- Quick Actions -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <h6 class="text-dark font-weight-bold mb-0">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('kasir.cart.approval') }}" class="btn btn-lg w-100 bg-warning text-white mb-0 d-flex flex-column align-items-center justify-content-center" style="min-height: 120px;">
                            <i class="material-symbols-rounded mb-2" style="font-size: 2.5rem;">approval</i>
                            <span class="text-sm font-weight-bold">Approval Cart</span>
                            @if($pendingCartsCount > 0)
                                <span class="badge bg-white text-warning mt-1">{{ $pendingCartsCount }}</span>
                            @endif
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#" class="btn btn-lg w-100 bg-info text-white mb-0 d-flex flex-column align-items-center justify-content-center" style="min-height: 120px;">
                            <i class="material-symbols-rounded mb-2" style="font-size: 2.5rem;">analytics</i>
                            <span class="text-sm font-weight-bold">Laporan Harian</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('kasir.transaksi.riwayat') }}" class="btn btn-lg w-100 bg-success text-white mb-0 d-flex flex-column align-items-center justify-content-center" style="min-height: 120px;">
                            <i class="material-symbols-rounded mb-2" style="font-size: 2.5rem;">history</i>
                            <span class="text-sm font-weight-bold">Riwayat Transaksi</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('stok.index') }}" class="btn btn-lg w-100 bg-primary text-white mb-0 d-flex flex-column align-items-center justify-content-center" style="min-height: 120px;">
                            <i class="material-symbols-rounded mb-2" style="font-size: 2.5rem;">inventory_2</i>
                            <span class="text-sm font-weight-bold">Cek Stok</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Notifications -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <h6 class="text-dark font-weight-bold mb-0">Notifikasi Stok Minimum</h6>
            </div>
            <div class="card-body">
                @forelse($lowStockItems as $item)
                    <div class="list-group-item px-0 border-0 mb-2 bg-light rounded">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="icon icon-shape {{ $item->stok_tersedia == 0 ? 'bg-danger' : 'bg-warning' }} text-white rounded-circle">
                                    <i class="material-symbols-rounded opacity-10">warning</i>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="mb-0 text-sm font-weight-bold">{{ $item->nama_obat }}</h6>
                                <p class="text-xs text-muted mb-0">
                                    Stok tersisa: <strong>{{ $item->stok_tersedia ?? 0 }}</strong> 
                                    (Min: {{ $item->stok_minimum ?? 0 }})
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-3">
                        <i class="material-symbols-rounded text-success" style="font-size: 3rem;">check_circle</i>
                        <p class="text-sm text-muted mb-0 mt-2">Semua stok mencukupi</p>
                    </div>
                @endforelse
                
                @if($lowStockItems->count() > 0)
                    <a href="{{ route('stok.index') }}" class="btn btn-sm btn-outline-secondary w-100 mt-2">Lihat Semua</a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Pending Cart Approvals Table -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pb-0">
                <h6 class="text-dark font-weight-bold mb-0">Cart Menunggu Approval</h6>
                <a href="{{ route('kasir.cart.approval') }}" class="btn btn-sm btn-success mb-0">Lihat Semua</a>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Karyawan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Item</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Harga</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingCarts as $cart)
                                @php
                                    $totalItems = $cart->items->sum('jumlah');
                                    $totalPrice = $cart->items->sum(function($item) {
                                        return $item->jumlah * $item->harga_satuan;
                                    });
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $cart->user->nama ?? 'Unknown' }}</h6>
                                                <p class="text-xs text-secondary mb-0">ID: CART-{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $totalItems }} items</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">{{ $cart->created_at->diffForHumans() }}</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-warning">Pending</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('kasir.cart.showPayment', $cart->id) }}" class="btn btn-sm btn-success mb-0 me-1">Approve</a>
                                        <form action="{{ route('kasir.cart.reject', $cart->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger mb-0" onclick="return confirm('Yakin ingin reject cart ini?')">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="material-symbols-rounded text-success" style="font-size: 3rem;">check_circle</i>
                                        <p class="text-sm text-muted mb-0 mt-2">Tidak ada cart yang menunggu approval</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
