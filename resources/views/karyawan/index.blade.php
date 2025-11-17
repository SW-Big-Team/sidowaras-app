@extends('layouts.karyawan.app')

@section('title', 'Dashboard Karyawan')
@section('breadcrumb', 'Dashboard / Ringkasan')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h4 class="mb-1">Selamat datang kembali, {{ Auth::user()->nama ?? 'Tim Karyawan' }}</h4>
                <p class="mb-0 text-sm">Monitor cart pelanggan, status stock opname, dan alert penting secara ringkas.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('karyawan.cart.index') }}" class="btn btn-primary">Input Cart</a>
                <a href="{{ route('stok.index') }}" class="btn btn-outline-primary">Lihat Stok</a>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @php
            $metrics = [
                ['label' => 'Cart Aktif Saya', 'value' => '3', 'unit' => 'cart', 'icon' => 'shopping_cart', 'trend' => '+2 today'],
                ['label' => 'Stok Opname Hari Ini', 'value' => '45', 'unit' => 'item', 'icon' => 'fact_check', 'trend' => '6 gudang selesai'],
                ['label' => 'Obat Expired', 'value' => '5', 'unit' => 'item', 'icon' => 'event_busy', 'trend' => 'butuh tindakan'],
                ['label' => 'Stok Hampir Habis', 'value' => '12', 'unit' => 'item', 'icon' => 'inventory', 'trend' => 'prioritas restock'],
            ];
        @endphp
        @foreach($metrics as $metric)
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-xs text-muted mb-2">{{ $metric['label'] }}</p>
                            <h3 class="fw-semibold mb-1">{{ $metric['value'] }} <span class="text-sm text-muted text-capitalize">{{ $metric['unit'] }}</span></h3>
                            <span class="text-xs text-muted">{{ $metric['trend'] }}</span>
                        </div>
                        <div class="stats-card-icon">
                            <i class="material-symbols-rounded">{{ $metric['icon'] }}</i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4 mt-1">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header border-0 pb-0">
                    <h6 class="mb-1">Aksi Cepat</h6>
                    <p class="text-sm text-muted mb-0">Pekerjaan utama setiap shift</p>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('karyawan.cart.index') }}" class="btn btn-primary d-flex justify-content-between align-items-center">
                            <div>
                                <strong class="d-block">Input Cart Pelanggan</strong>
                                <span class="text-sm fw-normal">Catat permintaan dan kirim ke kasir</span>
                            </div>
                            <i class="material-symbols-rounded">north_east</i>
                        </a>
                        <a href="{{ route('stok.index') }}" class="btn btn-outline-primary d-flex justify-content-between align-items-center">
                            <div>
                                <strong class="d-block">Stok Opname</strong>
                                <span class="text-sm fw-normal">Lanjutkan sesi yang sedang berlangsung</span>
                            </div>
                            <i class="material-symbols-rounded">inventory_2</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header border-0 pb-0">
                    <h6 class="mb-1">Cart Saya - Status Approval</h6>
                    <p class="text-sm text-muted mb-0">Pantau progres cart terakhir yang sudah dikirim</p>
                </div>
                <div class="card-body px-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID Cart</th>
                                    <th scope="col">Total Item</th>
                                    <th scope="col">Total Harga</th>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CART-008</td>
                                    <td>15 item</td>
                                    <td class="fw-semibold text-primary">Rp 560.000</td>
                                    <td><span class="text-xs text-muted">15 menit lalu</span></td>
                                    <td><span class="badge bg-warning text-dark">Pending approval</span></td>
                                </tr>
                                <tr>
                                    <td>CART-007</td>
                                    <td>8 item</td>
                                    <td class="fw-semibold text-primary">Rp 320.000</td>
                                    <td><span class="text-xs text-muted">1 jam lalu</span></td>
                                    <td><span class="badge bg-success text-white">Approved</span></td>
                                </tr>
                                <tr>
                                    <td>CART-006</td>
                                    <td>12 item</td>
                                    <td class="fw-semibold text-primary">Rp 450.000</td>
                                    <td><span class="text-xs text-muted">3 jam lalu</span></td>
                                    <td><span class="badge bg-danger text-white">Perlu revisi</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header border-0 pb-0">
                    <h6 class="mb-1">Progress Stok Opname Bulan Ini</h6>
                    <p class="text-sm text-muted mb-0">Target 1.245 item • 78.7% selesai</p>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-sm">Progress keseluruhan</span>
                            <span class="text-sm fw-semibold">980 / 1.245</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 78.7%" aria-valuenow="78.7" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 rounded-4" style="background: var(--sw-surface-alt);">
                                <p class="text-xs text-muted mb-1">Target Harian</p>
                                <h5 class="mb-0">42 item</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-4" style="background: var(--sw-surface-alt);">
                                <p class="text-xs text-muted mb-1">Sisa Hari</p>
                                <h5 class="mb-0">7 hari</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header border-0 pb-0">
                    <h6 class="mb-1">Aktivitas Hari Ini</h6>
                    <p class="text-sm text-muted mb-0">Log aktivitas terakhir dari tim</p>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step bg-success text-white">
                                <i class="material-symbols-rounded text-sm">check_circle</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-sm fw-semibold mb-0">Submit cart CART-008</h6>
                                <p class="text-xs text-muted mb-1">15 item • Rp 560.000</p>
                                <span class="text-xs text-muted">15 menit yang lalu</span>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step bg-info text-white">
                                <i class="material-symbols-rounded text-sm">fact_check</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-sm fw-semibold mb-0">Stok opname Gudang A</h6>
                                <p class="text-xs text-muted mb-1">45 item tercatat</p>
                                <span class="text-xs text-muted">2 jam yang lalu</span>
                            </div>
                        </div>
                        <div class="timeline-block">
                            <span class="timeline-step bg-warning text-white">
                                <i class="material-symbols-rounded text-sm">qr_code_scanner</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-sm fw-semibold mb-0">Scan barcode - Customer service</h6>
                                <p class="text-xs text-muted mb-1">Membantu pelanggan mencari obat</p>
                                <span class="text-xs text-muted">3 jam yang lalu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h6 class="mb-1">Notifikasi Stok</h6>
                    <p class="text-sm text-muted mb-0">Item yang memerlukan tindakan segera</p>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex align-items-center justify-content-between px-0">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stats-card-icon" aria-hidden="true">
                                    <i class="material-symbols-rounded">warning</i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Paracetamol 500mg — EXPIRED</h6>
                                    <p class="text-xs text-muted mb-0">Kadaluarsa 01 Okt 2025 • 15 box</p>
                                </div>
                            </div>
                            <button class="btn btn-outline-danger btn-sm">Laporkan</button>
                        </div>
                        <div class="list-group-item d-flex align-items-center justify-content-between px-0">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stats-card-icon" aria-hidden="true">
                                    <i class="material-symbols-rounded">inventory_2</i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Amoxicillin 500mg — LOW STOCK</h6>
                                    <p class="text-xs text-muted mb-0">Sisa 28 box • Min 40</p>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm">Ajukan Restock</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
