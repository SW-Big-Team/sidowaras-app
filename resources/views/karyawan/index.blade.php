@extends('layouts.karyawan.app')

@section('title', 'Dashboard Karyawan')
@section('breadcrumb', 'Dashboard / Ringkasan')

@section('content')
<div class="container-fluid py-4">
    <!-- Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                                    <i class="fas fa-circle text-xxs me-1"></i> Online
                                </span>
                                <span class="text-muted text-sm">{{ now()->format('l, d F Y') }}</span>
                            </div>
                            <h3 class="font-weight-bold mb-1 text-dark">Halo, {{ Auth::user()->nama ?? 'Karyawan' }}! 👋</h3>
                            <p class="text-muted mb-0">
                                Siap untuk memulai shift hari ini? Cek stok opname dan permintaan cart terbaru.
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('karyawan.cart.index') }}" class="btn btn-primary mb-0">
                                <i class="material-symbols-rounded align-middle me-1">add_shopping_cart</i>
                                Input Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4 mb-4">
        @php
            $metrics = [
                [
                    'label' => 'Cart Aktif',
                    'value' => $activeCartCount,
                    'sub' => 'Menunggu checkout',
                    'icon' => 'shopping_cart',
                    'color' => 'primary',
                ],
                [
                    'label' => 'Stok Opname',
                    'value' => $stockOpnameProgress . '%',
                    'sub' => 'Progress hari ini',
                    'icon' => 'inventory_2',
                    'color' => 'success',
                ],
                [
                    'label' => 'Item Expired',
                    'value' => $expiredItemsCount,
                    'sub' => 'Butuh tindakan',
                    'icon' => 'event_busy',
                    'color' => 'danger',
                ],
                [
                    'label' => 'Total Transaksi',
                    'value' => $totalTransactions,
                    'sub' => 'Shift ini',
                    'icon' => 'receipt_long',
                    'color' => 'info',
                ],
            ];
        @endphp

        @foreach($metrics as $metric)
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold text-muted">{{ $metric['label'] }}</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $metric['value'] }}
                                    <span class="text-xs text-muted font-weight-normal d-block mt-1">{{ $metric['sub'] }}</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-{{ $metric['color'] }} shadow text-center border-radius-md">
                                <i class="material-symbols-rounded text-lg opacity-10" aria-hidden="true">{{ $metric['icon'] }}</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-4">
        <!-- Left Column: Quick Actions & Progress -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="text-dark font-weight-bold mb-0">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('karyawan.cart.index') }}" class="card card-body border shadow-none h-100 text-center p-3 hover-scale transition-base text-decoration-none">
                                <div class="icon icon-shape bg-primary-subtle text-primary rounded-circle mb-2 mx-auto">
                                    <i class="material-symbols-rounded">point_of_sale</i>
                                </div>
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Transaksi</h6>
                                <span class="text-xs text-muted">Input pesanan</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('stok.index') }}" class="card card-body border shadow-none h-100 text-center p-3 hover-scale transition-base text-decoration-none">
                                <div class="icon icon-shape bg-success-subtle text-success rounded-circle mb-2 mx-auto">
                                    <i class="material-symbols-rounded">qr_code_scanner</i>
                                </div>
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Cek Stok</h6>
                                <span class="text-xs text-muted">Scan barcode</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">Target Stok Opname</h6>
                        <span class="badge bg-primary-subtle text-primary rounded-pill">Hari Ini</span>
                    </div>
                    
                    <div class="d-flex align-items-end gap-2 mb-2">
                        <h3 class="fw-bold mb-0">{{ $stockOpnameChecked }}</h3>
                        <span class="text-muted mb-1">/ {{ $stockOpnameTotal }} item</span>
                    </div>
                    
                    <div class="progress-wrapper">
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-gradient-primary" role="progressbar" aria-valuenow="{{ $stockOpnameProgress }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $stockOpnameProgress }}%;"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between text-xs text-muted mt-2">
                        <span><i class="fas fa-clock me-1"></i> Progress Harian</span>
                        <span>{{ $stockOpnameProgress }}% Selesai</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Recent Activity -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="text-dark font-weight-bold mb-0">Aktivitas Terkini</h6>
                    <a href="{{ route('karyawan.transaksi.index') }}" class="text-primary text-sm font-weight-bold">Lihat Semua</a>
                </div>
                <div class="card-body p-0 pt-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities as $activity)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-gradient-{{ $activity['type'] == 'cart' ? 'info' : 'success' }} me-3 my-auto">
                                                <i class="material-symbols-rounded text-white text-sm">{{ $activity['type'] == 'cart' ? 'shopping_bag' : 'receipt' }}</i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $activity['type'] == 'cart' ? 'CART-' . substr($activity['uuid'], 0, 8) : $activity['uuid'] }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $activity['items_count'] }} items</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-{{ $activity['status'] == 'Completed' || $activity['status'] == 'Approved' ? 'success' : 'warning' }}">
                                            {{ $activity['status'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">Rp {{ number_format($activity['total'], 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold text-muted">{{ $activity['date']->diffForHumans() }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ $activity['type'] == 'cart' ? route('karyawan.cart.show', $activity['id']) : route('karyawan.transaksi.show', $activity['id']) }}" class="btn btn-link text-secondary mb-0">
                                            <i class="material-symbols-rounded text-sm">arrow_forward</i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <p class="text-sm text-muted mb-0">Belum ada aktivitas hari ini.</p>
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
</div>

<style>
    .hover-scale {
        transition: transform 0.2s ease-in-out;
    }
    .hover-scale:hover {
        transform: translateY(-5px);
    }
</style>
@endsection
