@extends('layouts.admin.app')
@section('title', 'Detail Transaksi #' . $transaksi->no_transaksi)

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Transaksi</a></li>
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.transaksi.riwayat') }}">Riwayat</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge"><i class="material-symbols-rounded">receipt_long</i> Detail Transaksi</span>
                    <h2 class="welcome-title">{{ $transaksi->no_transaksi }}</h2>
                    <p class="welcome-subtitle">{{ $transaksi->tgl_transaksi->format('d F Y, H:i') }} WIB • {{ count($detail) }} item</p>
                </div>
                <div class="welcome-stats">
                    <a href="{{ route('admin.transaksi.riwayat') }}" class="stat-pill"><i class="material-symbols-rounded">arrow_back</i><span>Kembali</span></a>
                    <button onclick="window.print()" class="stat-pill success"><i class="material-symbols-rounded">print</i><span>Cetak</span></button>
                </div>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">receipt</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">payments</i></div>
            </div>
        </div>
    </div>
</div>

{{-- Info Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="info-card">
            <div class="info-icon primary"><i class="material-symbols-rounded">person</i></div>
            <div class="info-content">
                <span class="info-label">Kasir Bertugas</span>
                <span class="info-value">{{ $transaksi->user->nama_lengkap }}</span>
                <span class="info-meta">{{ $transaksi->user->role->nama_role }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-card">
            <div class="info-icon {{ $transaksi->metode_pembayaran === 'tunai' ? 'warning' : 'info' }}">
                <i class="material-symbols-rounded">{{ $transaksi->metode_pembayaran === 'tunai' ? 'payments' : 'credit_card' }}</i>
            </div>
            <div class="info-content">
                <span class="info-label">Metode Pembayaran</span>
                <span class="info-value">{{ $transaksi->metode_pembayaran === 'tunai' ? 'Tunai (Cash)' : 'Non Tunai' }}</span>
                <span class="info-meta">Pembayaran diterima</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-card">
            <div class="info-icon success"><i class="material-symbols-rounded">check_circle</i></div>
            <div class="info-content">
                <span class="info-label">Status Pembayaran</span>
                <span class="info-value">LUNAS</span>
                <span class="info-meta">Transaksi selesai</span>
            </div>
        </div>
    </div>
</div>

{{-- Items Table --}}
<div class="card pro-card mb-4" id="invoice-card">
    <div class="card-header pro-card-header">
        <div class="header-left">
            <div class="header-icon"><i class="material-symbols-rounded">list_alt</i></div>
            <div><h6 class="header-title">Item Pembelian</h6><p class="header-subtitle">{{ count($detail) }} produk</p></div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table pro-table mb-0">
                <thead><tr><th>Item Obat</th><th class="text-center">Batch</th><th class="text-center">Qty</th><th class="text-end">Harga</th><th class="text-end">Total</th></tr></thead>
                <tbody>
                    @foreach($detail as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="item-icon"><i class="material-symbols-rounded">medication</i></div>
                                    <div><span class="fw-bold d-block">{{ $item->batch->obat->nama_obat }}</span><span class="text-xs text-secondary">{{ $item->batch->obat->kategori->nama_kategori ?? 'Umum' }}</span></div>
                                </div>
                            </td>
                            <td class="text-center"><span class="batch-badge">{{ $item->batch->no_batch }}</span></td>
                            <td class="text-center"><span class="qty-badge">{{ $item->jumlah }}</span></td>
                            <td class="text-end text-secondary">Rp {{ number_format($item->harga_saat_transaksi, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Payment Summary --}}
<div class="row justify-content-end">
    <div class="col-md-5">
        <div class="payment-summary">
            <div class="summary-header"><i class="material-symbols-rounded">calculate</i><span>Ringkasan Pembayaran</span></div>
            <div class="summary-body">
                <div class="summary-row total"><span>Total Tagihan</span><span class="value">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span></div>
                @if($transaksi->metode_pembayaran === 'tunai')
                    <div class="summary-row"><span>Uang Diterima</span><span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span></div>
                    <div class="summary-row change"><span>Kembalian</span><span class="badge-change">+ Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span></div>
                @endif
            </div>
            <div class="summary-footer"><i class="material-symbols-rounded">info</i><span>ID: {{ $transaksi->id }}</span></div>
        </div>
    </div>
</div>

<div class="text-center mt-4 text-secondary text-sm">Terima kasih telah berbelanja di <strong>Sidowaras Pharmacy</strong></div>

@push('styles')
<style>
:root { --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6; --primary: #8b5cf6; --secondary: #64748b; }
.welcome-banner { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); border-radius: 16px; padding: 2rem; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; }
.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.15); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.7); font-size: 0.9rem; margin: 0 0 16px; }
.welcome-stats { display: flex; gap: 10px; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.15); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.stat-pill:hover { background: rgba(255,255,255,0.25); color: white; }
.stat-pill.success { background: rgba(16,185,129,0.4); }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: rgba(255,255,255,0.6); font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.info-card { background: white; border-radius: 12px; padding: 1.25rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
.info-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.info-icon i { font-size: 24px; color: white; }
.info-icon.primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.info-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.info-icon.info { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.info-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
.info-content { display: flex; flex-direction: column; }
.info-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; font-weight: 600; }
.info-value { font-size: 1rem; font-weight: 600; color: #1e293b; }
.info-meta { font-size: 0.75rem; color: var(--secondary); }
.pro-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.06); overflow: hidden; }
.pro-card-header { padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; }
.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #1e293b, #334155); display: flex; align-items: center; justify-content: center; }
.header-icon i { color: #000000 !important; font-size: 20px; }
.header-title { font-size: 1rem; font-weight: 600; color: #000000 !important; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: #000000 !important; margin: 0; }
.pro-table { margin: 0; }
.pro-table thead { background: linear-gradient(135deg, #1e293b, #334155); }
.pro-table th { font-size: 0.7rem; font-weight: 600; color: white; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border: none; }
.pro-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.pro-table tbody tr:hover { background: #f8fafc; }
.item-icon { width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); display: flex; align-items: center; justify-content: center; }
.item-icon i { color: white; font-size: 18px; }
.batch-badge { font-size: 0.75rem; padding: 4px 10px; border-radius: 6px; background: #f1f5f9; color: var(--secondary); font-weight: 500; }
.qty-badge { font-size: 0.85rem; font-weight: 700; color: #1e293b; }
.payment-summary { background: white; border-radius: 16px; box-shadow: 0 4px 16px rgba(0,0,0,0.06); overflow: hidden; }
.summary-header { display: flex; align-items: center; gap: 8px; padding: 1rem 1.25rem; background: linear-gradient(135deg, #1e293b, #334155); color: white; font-weight: 600; }
.summary-body { padding: 1.25rem; }
.summary-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; color: var(--secondary); }
.summary-row.total { font-size: 1.1rem; font-weight: 700; color: #1e293b; padding: 12px 0; border-bottom: 1px solid #f1f5f9; margin-bottom: 8px; }
.summary-row.total .value { color: #1e293b; }
.summary-row.change { padding-top: 12px; border-top: 1px solid #f1f5f9; margin-top: 8px; }
.badge-change { background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 6px 12px; border-radius: 6px; font-weight: 600; }
.summary-footer { display: flex; align-items: center; gap: 6px; padding: 0.75rem 1.25rem; background: #f8fafc; font-size: 0.75rem; color: var(--secondary); }
@media print { .sidenav, .navbar, .sidebar-toggle-plugin, .btn, .breadcrumb, .welcome-banner, .stat-pill { display: none !important; } .card { box-shadow: none !important; } @page { margin: 1.5cm; size: A4; } body { background: white !important; } }
@media (max-width: 768px) { .welcome-banner { flex-direction: column; text-align: center; } .welcome-stats { justify-content: center; } .welcome-illustration { display: none; } }
</style>
@endpush
@endsection