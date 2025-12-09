@extends('layouts.admin.app')
@section('title', 'Riwayat Transaksi')

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Transaksi</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Riwayat Transaksi</li>
    </ol>
@endsection

@section('content')
    {{-- Welcome Header --}}
    <div class="row mb-4">
        <div class="col-12">
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show text-white mb-3" role="alert">
                    <span class="alert-icon align-middle"><i class="material-symbols-rounded text-md">warning</i></span>
                    <span class="alert-text"><strong>Perhatian!</strong> {{ session('warning') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
            @endif

            <div class="welcome-banner transactions">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <span class="greeting-badge">
                            <i class="material-symbols-rounded">receipt_long</i>
                            Riwayat Transaksi
                        </span>
                        <h2 class="welcome-title">Daftar Transaksi</h2>
                        <p class="welcome-subtitle">Pantau dan kelola seluruh transaksi yang telah diproses di apotek Anda.
                        </p>
                    </div>
                    <div class="welcome-stats">
                        <div class="stat-pill">
                            <i class="material-symbols-rounded">receipt</i>
                            <span>{{ $transaksis->total() }} transaksi</span>
                        </div>
                    </div>
                </div>
                <div class="welcome-illustration">
                    <div class="floating-icon icon-1"><i class="material-symbols-rounded">payments</i></div>
                    <div class="floating-icon icon-2"><i class="material-symbols-rounded">shopping_cart</i></div>
                    <div class="floating-icon icon-3"><i class="material-symbols-rounded">credit_card</i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Metric Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="metric-card dark">
                <div class="metric-icon">
                    <i class="material-symbols-rounded">receipt</i>
                </div>
                <div class="metric-content">
                    <span class="metric-label">Total Transaksi</span>
                    <h3 class="metric-value">{{ $transaksis->total() }}</h3>
                    <div class="metric-change neutral">
                        <i class="material-symbols-rounded">history</i>
                        <span>Seluruh tercatat</span>
                    </div>
                </div>
                <div class="metric-glow"></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="metric-card success">
                <div class="metric-icon">
                    <i class="material-symbols-rounded">payments</i>
                </div>
                <div class="metric-content">
                    <span class="metric-label">Total Pendapatan</span>
                    <h3 class="metric-value">Rp {{ number_format($transaksis->sum('total_harga') / 1000, 0, ',', '.') }}K
                    </h3>
                    <div class="metric-change neutral">
                        <i class="material-symbols-rounded">trending_up</i>
                        <span>Estimasi pendapatan</span>
                    </div>
                </div>
                <div class="metric-glow"></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="metric-card warning">
                <div class="metric-icon">
                    <i class="material-symbols-rounded">monetization_on</i>
                </div>
                <div class="metric-content">
                    <span class="metric-label">Tunai</span>
                    <h3 class="metric-value">{{ $transaksis->where('metode_pembayaran', 'tunai')->count() }}</h3>
                    <div class="metric-change neutral">
                        <i class="material-symbols-rounded">payments</i>
                        <span>Transaksi cash</span>
                    </div>
                </div>
                <div class="metric-glow"></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="metric-card info">
                <div class="metric-icon">
                    <i class="material-symbols-rounded">credit_card</i>
                </div>
                <div class="metric-content">
                    <span class="metric-label">Non Tunai</span>
                    <h3 class="metric-value">{{ $transaksis->where('metode_pembayaran', 'non_tunai')->count() }}</h3>
                    <div class="metric-change neutral">
                        <i class="material-symbols-rounded">account_balance</i>
                        <span>Transaksi cashless</span>
                    </div>
                </div>
                <div class="metric-glow"></div>
            </div>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card pro-card mb-4">
        <div class="card-header pro-card-header">
            <div class="header-left">
                <div class="header-icon primary">
                    <i class="material-symbols-rounded">filter_alt</i>
                </div>
                <div>
                    <h6 class="header-title">Filter Transaksi</h6>
                    <p class="header-subtitle">Saring berdasarkan tanggal dan metode</p>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Tanggal Dari</label>
                    <input type="date" name="from" value="{{ $from }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Tanggal Sampai</label>
                    <input type="date" name="to" value="{{ $to }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Metode Pembayaran</label>
                    <select name="metode" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        <option value="tunai" {{ $metode == 'tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="non_tunai" {{ $metode == 'non_tunai' ? 'selected' : '' }}>Non Tunai</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-pro flex-grow-1">
                            <i class="material-symbols-rounded">search</i> Filter
                        </button>
                        <a href="{{ route('admin.transaksi.riwayat') }}" class="btn-outline-pro" title="Reset">
                            <i class="material-symbols-rounded">refresh</i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Transactions Table --}}
    <div class="card pro-card">
        <div class="card-header pro-card-header">
            <div class="header-left">
                <div class="header-icon">
                    <i class="material-symbols-rounded">list_alt</i>
                </div>
                <div>
                    <h6 class="header-title">Data Transaksi</h6>
                    <p class="header-subtitle">{{ $transaksis->total() }} transaksi ditemukan</p>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table pro-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Transaksi</th>
                            <th>Kasir</th>
                            <th class="text-end">Total Harga</th>
                            <th class="text-center">Metode</th>
                            <th>Keterangan</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $index => $t)
                            <tr>
                                <td>
                                    <span class="id-badge">{{ $transaksis->firstItem() + $index }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="trx-icon">
                                            <i class="material-symbols-rounded">receipt</i>
                                        </div>
                                        <span class="trx-number">{{ $t->no_transaksi }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">{{ strtoupper(substr($t->user->nama_lengkap, 0, 1)) }}</div>
                                        <div>
                                            <span class="fw-bold">{{ $t->user->nama_lengkap }}</span>
                                            <span class="role-text">{{ $t->user->role->nama_role }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="price-value">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    @if($t->metode_pembayaran === 'tunai')
                                        <span class="method-badge warning">
                                            <i class="material-symbols-rounded">payments</i>
                                            Tunai
                                        </span>
                                    @else
                                        <span class="method-badge info">
                                            <i class="material-symbols-rounded">credit_card</i>
                                            Non Tunai
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-xs text-secondary">{{ str()->limit($t->keterangan, 30) ?? '-' }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="date-cell">
                                        <span class="date-main">{{ $t->tgl_transaksi->format('d M Y') }}</span>
                                        <span class="date-time">{{ $t->tgl_transaksi->format('H:i') }} WIB</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.transaksi.show', $t->id) }}" class="action-btn view"
                                        title="Lihat Detail">
                                        <i class="material-symbols-rounded">visibility</i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-icon"><i class="material-symbols-rounded">receipt_long</i></div>
                                        <h6>Belum ada transaksi</h6>
                                        <p>Tidak ada transaksi dalam periode ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($transaksis->hasPages())
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <p class="text-xs text-secondary mb-0">
                        Menampilkan <span class="fw-bold">{{ $transaksis->firstItem() ?? 0 }}</span> -
                        <span class="fw-bold">{{ $transaksis->lastItem() ?? 0 }}</span> dari
                        <span class="fw-bold">{{ $transaksis->total() }}</span> data
                    </p>
                    {{ $transaksis->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --primary: #8b5cf6;
            --secondary: #64748b;
            --dark: #1e293b;
        }

        .welcome-banner.transactions {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border-radius: 16px;
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .welcome-content {
            position: relative;
            z-index: 2;
        }

        .greeting-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.15);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            color: white;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .welcome-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            margin: 0 0 8px;
        }

        .welcome-subtitle {
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.9rem;
            margin: 0 0 16px;
            max-width: 500px;
        }

        .welcome-stats {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            color: white;
            font-weight: 500;
        }

        .welcome-illustration {
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            gap: 1rem;
        }

        .floating-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: float 3s ease-in-out infinite;
        }

        .floating-icon i {
            color: white;
            font-size: 24px;
        }

        .floating-icon.icon-2 {
            animation-delay: 0.5s;
        }

        .floating-icon.icon-3 {
            animation-delay: 1s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .metric-card {
            background: white;
            border-radius: 16px;
            padding: 1.25rem;
            display: flex;
            gap: 1rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .metric-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .metric-icon i {
            font-size: 26px;
        }

        .metric-card.dark .metric-icon {
            background: rgba(30, 41, 59, 0.12);
        }

        .metric-card.dark .metric-icon i {
            color: var(--dark);
        }

        .metric-card.success .metric-icon {
            background: rgba(16, 185, 129, 0.12);
        }

        .metric-card.success .metric-icon i {
            color: var(--success);
        }

        .metric-card.warning .metric-icon {
            background: rgba(245, 158, 11, 0.12);
        }

        .metric-card.warning .metric-icon i {
            color: var(--warning);
        }

        .metric-card.info .metric-icon {
            background: rgba(59, 130, 246, 0.12);
        }

        .metric-card.info .metric-icon i {
            color: var(--info);
        }

        .metric-content {
            flex: 1;
        }

        .metric-label {
            font-size: 0.7rem;
            color: var(--secondary);
            text-transform: uppercase;
            font-weight: 600;
        }

        .metric-value {
            font-size: 1.35rem;
            font-weight: 700;
            color: #1e293b;
            margin: 4px 0;
        }

        .metric-change {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .metric-change i {
            font-size: 16px;
        }

        .metric-change.neutral {
            color: var(--secondary);
        }

        .metric-glow {
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            right: -30px;
            bottom: -30px;
            opacity: 0.08;
        }

        .metric-card.dark .metric-glow {
            background: var(--dark);
        }

        .metric-card.success .metric-glow {
            background: var(--success);
        }

        .metric-card.warning .metric-glow {
            background: var(--warning);
        }

        .metric-card.info .metric-glow {
            background: var(--info);
        }

        .pro-card {
            background: white;
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .pro-card-header {
            padding: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #f1f5f9;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #1e293b, #475569);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-icon i {
            color: #000000 !important;
            font-size: 20px;
        }

        .header-icon.primary {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .header-title {
            font-size: 1rem;
            font-weight: 600;
            color: #000000 !important;
            margin: 0;
        }

        .header-subtitle {
            font-size: 0.75rem;
            color: #000000 !important;
            margin: 0;
        }

        .btn-pro {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #1e293b, #475569);
            color: white;
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-pro:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 41, 59, 0.4);
        }

        .btn-pro i {
            font-size: 18px;
        }

        .btn-outline-pro {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            background: white;
            color: var(--secondary);
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-outline-pro:hover {
            background: #f8fafc;
            color: var(--dark);
        }

        .btn-outline-pro i {
            font-size: 18px;
        }

        .pro-table {
            margin: 0;
        }

        .pro-table thead {
            background: linear-gradient(135deg, #1e293b, #334155);
        }

        .pro-table th {
            font-size: 0.7rem;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            border: none;
        }

        .pro-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .pro-table tbody tr:hover {
            background: #f8fafc;
        }

        .id-badge {
            font-family: monospace;
            font-weight: 600;
            color: var(--secondary);
            font-size: 0.8rem;
        }

        .trx-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, #1e293b, #475569);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .trx-icon i {
            color: white;
            font-size: 16px;
        }

        .trx-number {
            font-family: monospace;
            font-weight: 600;
            color: #1e293b;
            font-size: 0.85rem;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-cell>div {
            display: flex;
            flex-direction: column;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .role-text {
            font-size: 0.7rem;
            color: var(--secondary);
        }

        .price-value {
            font-weight: 700;
            color: #1e293b;
        }

        .method-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 6px;
            font-weight: 600;
        }

        .method-badge i {
            font-size: 14px;
        }

        .method-badge.warning {
            background: rgba(245, 158, 11, 0.12);
            color: var(--warning);
        }

        .method-badge.info {
            background: rgba(59, 130, 246, 0.12);
            color: var(--info);
        }

        .date-cell {
            display: flex;
            flex-direction: column;
        }

        .date-main {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.85rem;
        }

        .date-time {
            font-size: 0.7rem;
            color: var(--secondary);
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .action-btn i {
            font-size: 18px;
        }

        .action-btn.view {
            background: rgba(59, 130, 246, 0.12);
            color: var(--info);
        }

        .action-btn.view:hover {
            background: var(--info);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
        }

        .empty-icon i {
            font-size: 28px;
            color: var(--secondary);
        }

        .empty-state h6 {
            color: #475569;
            margin-bottom: 4px;
        }

        .empty-state p {
            font-size: 0.8rem;
            color: var(--secondary);
            margin: 0;
        }

        @media (max-width: 768px) {
            .welcome-banner.transactions {
                flex-direction: column;
                text-align: center;
            }

            .welcome-stats {
                justify-content: center;
            }

            .welcome-illustration {
                display: none;
            }
        }
    </style>
@endpush