@extends('layouts.admin.app')
@section('title', 'Data Obat')

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Obat</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Data Obat</li>
    </ol>
@endsection

@section('content')
    {{-- Welcome Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-banner">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <span class="greeting-badge">
                            <i class="material-symbols-rounded">medication</i>
                            Manajemen Obat
                        </span>
                        <h2 class="welcome-title">Data Master Obat</h2>
                        <p class="welcome-subtitle">Kelola informasi obat, kategori, satuan, dan kandungan untuk apotek
                            Anda.</p>
                    </div>
                    <div class="welcome-stats">
                        <button type="button" class="btn-import-highlight" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                            <i class="material-symbols-rounded">upload_file</i>
                            <span>Import CSV</span>
                        </button>
                        <a href="{{ route('admin.obat.create') }}" class="stat-pill success">
                            <i class="material-symbols-rounded">add_circle</i>
                            <span>Tambah Obat</span>
                        </a>
                    </div>
                </div>
                <div class="welcome-illustration">
                    <div class="floating-icon icon-1"><i class="material-symbols-rounded">pill</i></div>
                    <div class="floating-icon icon-2"><i class="material-symbols-rounded">vaccines</i></div>
                    <div class="floating-icon icon-3"><i class="material-symbols-rounded">local_pharmacy</i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Metric Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="metric-card primary">
                <div class="metric-icon">
                    <i class="material-symbols-rounded">medication</i>
                </div>
                <div class="metric-content">
                    <span class="metric-label">Total Obat</span>
                    <h3 class="metric-value">{{ $obats->total() }}</h3>
                    <div class="metric-change neutral">
                        <i class="material-symbols-rounded">inventory_2</i>
                        <span>Item terdaftar</span>
                    </div>
                </div>
                <div class="metric-glow"></div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="metric-card success">
                <div class="metric-icon">
                    <i class="material-symbols-rounded">new_releases</i>
                </div>
                <div class="metric-content">
                    <span class="metric-label">Obat Baru</span>
                    <h3 class="metric-value">{{ \App\Models\Obat::where('created_at', '>=', now()->subDays(7))->count() }}
                    </h3>
                    <div class="metric-change neutral">
                        <i class="material-symbols-rounded">calendar_today</i>
                        <span>7 hari terakhir</span>
                    </div>
                </div>
                <div class="metric-glow"></div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="metric-card warning">
                <div class="metric-icon">
                    <i class="material-symbols-rounded">warning</i>
                </div>
                <div class="metric-content">
                    <span class="metric-label">Stok Rendah</span>
                    <h3 class="metric-value">{{ $obatStokRendah }}</h3>
                    <div class="metric-change {{ $obatStokRendah > 0 ? 'warning' : 'neutral' }}">
                        <i class="material-symbols-rounded">{{ $obatStokRendah > 0 ? 'priority_high' : 'check_circle' }}</i>
                        <span>{{ $obatStokRendah > 0 ? 'Perlu restok' : 'Stok aman' }}</span>
                    </div>
                </div>
                <div class="metric-glow"></div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded align-middle">check_circle</i></span>
            <span class="alert-text fw-bold">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
            <span class="alert-text fw-bold">{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
    @endif

    {{-- Data Table --}}
    <div class="card pro-card">
        <div class="card-header pro-card-header">
            <div class="header-left">
                <div class="header-icon">
                    <i class="material-symbols-rounded">list_alt</i>
                </div>
                <div>
                    <h6 class="header-title">Data Obat</h6>
                    <p class="header-subtitle">{{ $obats->total() }} item terdaftar</p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <form method="GET" action="{{ route('admin.obat.index') }}"
                    class="d-flex align-items-center gap-2 flex-nowrap">
                    {{-- Kategori Filter --}}
                    <div class="input-group" style="width: auto;">
                        <span class="input-group-text bg-white" style="border-radius: 8px 0 0 8px; border-right: 0;">
                            <i class="material-symbols-rounded text-secondary" style="font-size: 18px;">filter_list</i>
                        </span>
                        <select name="kategori" class="form-control form-select-sm" onchange="this.form.submit()"
                            style="min-width: 150px; border-radius: 0 8px 8px 0;">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Search Input --}}
                    <div class="input-group" style="width: 200px;">
                        <span class="input-group-text bg-white" style="border-radius: 8px 0 0 8px; border-right: 0;">
                            <i class="material-symbols-rounded text-secondary" style="font-size: 18px;">search</i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control ps-0"
                            style="border-radius: 0 8px 8px 0; border-left: 0;" placeholder="Cari obat...">
                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                    </div>
                    <button type="submit" class="btn-pro-sm">
                        <i class="material-symbols-rounded">search</i>
                    </button>
                    @if(request('search') || request('kategori'))
                        <a href="{{ route('admin.obat.index') }}" class="btn-outline-pro-sm" title="Hapus Filter">
                            <i class="material-symbols-rounded">close</i>
                        </a>
                    @endif
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table pro-table mb-0">
                    <thead>
                        <tr>
                            <th>Nama Obat</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Kandungan</th>
                            <th class="text-center">Stok Min</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($obats as $obat)
                            @php
                                $kandunganList = $obat->kandungan->flatMap(function ($k) {
                                    return is_array($k->nama_kandungan) ? $k->nama_kandungan : [$k->nama_kandungan];
                                })->toArray();
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="obat-icon">
                                            <i class="material-symbols-rounded">pill</i>
                                        </div>
                                        <span class="fw-bold">{{ $obat->nama_obat }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="category-badge">{{ $obat->kategori->nama_kategori ?? '-' }}</span>
                                </td>
                                <td>
                                    @php
                                        // $obat->satuan is now an accessor returning collection
                                        $satuanNames = $obat->satuan->pluck('nama_satuan')->toArray();
                                    @endphp
                                    <span
                                        class="text-secondary">{{ !empty($satuanNames) ? implode(', ', $satuanNames) : '-' }}</span>
                                </td>
                                <td>
                                    @if(count($kandunganList) > 0)
                                        <span class="kandungan-text" title="{{ implode(', ', $kandunganList) }}">
                                            {{ Str::limit(implode(', ', $kandunganList), 30) }}
                                        </span>
                                    @else
                                        <span class="text-secondary">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="stock-badge">{{ $obat->stok_minimum }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.obat.edit', $obat->id) }}" class="action-btn edit"
                                            title="Edit">
                                            <i class="material-symbols-rounded">edit</i>
                                        </a>
                                        <form action="{{ route('admin.obat.destroy', $obat->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus obat {{ $obat->nama_obat }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Hapus">
                                                <i class="material-symbols-rounded">delete</i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-icon"><i class="material-symbols-rounded">medication</i></div>
                                        <h6>Belum ada data obat</h6>
                                        <p>Tambahkan obat baru untuk memulai</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($obats->hasPages())
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-xs text-secondary">Tampilkan</span>
                        <form method="GET" action="{{ route('admin.obat.index') }}" class="d-inline">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                            <select name="per_page" class="form-select form-select-sm" style="width: 70px;"
                                onchange="this.form.submit()">
                                @foreach([10, 25, 50, 100] as $size)
                                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                        <span class="text-xs text-secondary">data</span>
                    </div>
                    <p class="text-xs text-secondary mb-0">
                        <span class="fw-bold">{{ $obats->firstItem() ?? 0 }}</span> -
                        <span class="fw-bold">{{ $obats->lastItem() ?? 0 }}</span> dari
                        <span class="fw-bold">{{ $obats->total() }}</span>
                    </p>
                    {{ $obats->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

    {{-- Import Modal --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-pro">
                <div class="modal-header border-0 pb-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="modal-icon">
                            <i class="material-symbols-rounded">upload_file</i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0">Import Data Obat</h5>
                            <p class="text-muted small mb-0">Upload file CSV untuk import data obat</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Download Template Section --}}
                    <div class="template-section mb-4">
                        <h6 class="fw-semibold mb-2">1. Download Template</h6>
                        <p class="text-muted small mb-3">Download template terlebih dahulu, isi sesuai format, lalu upload.
                        </p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.obat.template', 'csv') }}" class="btn-template">
                                <i class="material-symbols-rounded">table_chart</i>
                                Download CSV
                            </a>
                        </div>
                    </div>

                    {{-- Info Alert --}}
                    <div class="info-alert mb-4">
                        <i class="material-symbols-rounded">info</i>
                        <div>
                            <strong>Panduan pengisian:</strong>
                            <ul class="mb-0 mt-1 ps-3">
                                <li><code>kategori</code> harus sesuai nama kategori yang sudah ada</li>
                                <li><code>satuan</code> harus sesuai nama satuan yang sudah ada</li>
                                <li><code>is_racikan</code> isi dengan 0 atau 1</li>
                                <li><code>kode_obat</code> kosongkan jika ingin auto-generate</li>
                            </ul>
                        </div>
                    </div>

                    {{-- Upload Form --}}
                    <form action="{{ route('admin.obat.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h6 class="fw-semibold mb-2">2. Upload File</h6>
                        <div class="upload-zone mb-3">
                            <input type="file" name="file" id="importFile" accept=".csv,.txt" required class="d-none">
                            <label for="importFile" class="upload-label">
                                <i class="material-symbols-rounded">cloud_upload</i>
                                <span class="upload-text">Klik untuk pilih file CSV</span>
                                <span class="upload-hint">Maksimal 2MB</span>
                            </label>
                            <div class="file-name-display" id="fileNameDisplay"></div>
                        </div>
                        <button type="submit" class="btn-import w-100">
                            <i class="material-symbols-rounded">upload</i>
                            Import Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Import Errors Alert --}}
    @if(session('import_errors') && count(session('import_errors')) > 0)
        <div class="modal fade show" id="importErrorsModal" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-danger"><i class="material-symbols-rounded me-2">warning</i>Import Errors
                        </h5>
                        <button type="button" class="btn-close" onclick="this.closest('.modal').remove()"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-unstyled mb-0">
                            @foreach(session('import_errors') as $error)
                                <li class="mb-2 text-danger small"><i class="material-symbols-rounded me-1"
                                        style="font-size: 14px;">error</i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
        }

        .welcome-banner {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
            background: rgba(255, 255, 255, 0.2);
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
            color: rgba(255, 255, 255, 0.85);
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
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            color: white;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .stat-pill:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        .stat-pill.success {
            background: rgba(16, 185, 129, 0.6);
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
            background: rgba(255, 255, 255, 0.15);
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

        .metric-card.primary .metric-icon {
            background: rgba(139, 92, 246, 0.12);
        }

        .metric-card.primary .metric-icon i {
            color: var(--primary);
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
            font-size: 1.5rem;
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

        .metric-change.warning {
            color: var(--warning);
        }

        .metric-glow {
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            right: -30px;
            bottom: -30px;
            opacity: 0.1;
        }

        .metric-card.success .metric-glow {
            background: var(--success);
        }

        .metric-card.warning .metric-glow {
            background: var(--warning);
        }

        .metric-card.primary .metric-glow {
            background: var(--primary);
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
            flex-wrap: wrap;
            gap: 12px;
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
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-icon i {
            color: #000000 !important;
            font-size: 20px;
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

        .btn-pro-sm {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            background: linear-gradient(135deg, #1e293b, #475569);
            color: white;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-pro-sm:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 41, 59, 0.4);
        }

        .btn-pro-sm i {
            font-size: 18px;
        }

        .btn-outline-pro-sm {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            background: white;
            color: var(--secondary);
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-outline-pro-sm:hover {
            background: #f8fafc;
            color: #1e293b;
        }

        .btn-outline-pro-sm i {
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

        .obat-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .obat-icon i {
            color: white;
            font-size: 18px;
        }

        .category-badge {
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 6px;
            background: rgba(139, 92, 246, 0.12);
            color: var(--primary);
            font-weight: 500;
        }

        .kandungan-text {
            font-size: 0.8rem;
            color: var(--secondary);
        }

        .stock-badge {
            font-size: 0.85rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 6px;
            background: #f1f5f9;
            color: #1e293b;
        }

        .action-buttons {
            display: flex;
            gap: 6px;
            justify-content: center;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .action-btn i {
            font-size: 18px;
        }

        .action-btn.edit {
            background: rgba(245, 158, 11, 0.12);
            color: var(--warning);
        }

        .action-btn.edit:hover {
            background: var(--warning);
            color: white;
        }

        .action-btn.delete {
            background: rgba(239, 68, 68, 0.12);
            color: var(--danger);
        }

        .action-btn.delete:hover {
            background: var(--danger);
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
            .welcome-banner {
                flex-direction: column;
                text-align: center;
            }

            .welcome-stats {
                justify-content: center;
            }

            .welcome-illustration {
                display: none;
            }

            .pro-card-header {
                flex-direction: column;
                align-items: stretch;
            }
        }

        /* Info Stat Pill */
        .stat-pill.info {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
            border: none;
        }

        .stat-pill.info:hover {
            background: #3b82f6;
            color: white;
        }

        /* Import Button Highlight */
        .btn-import-highlight {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .btn-import-highlight:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.5);
            animation: none;
        }

        .btn-import-highlight i {
            font-size: 20px;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
            }

            50% {
                box-shadow: 0 4px 25px rgba(245, 158, 11, 0.6);
            }
        }

        /* Import Modal */
        .modal-pro {
            border-radius: 16px;
            overflow: hidden;
        }

        .modal-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-icon i {
            color: white;
            font-size: 24px;
        }

        .btn-template {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: #f1f5f9;
            border-radius: 8px;
            color: #475569;
            font-weight: 500;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-template:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .btn-template i {
            font-size: 18px;
        }

        .info-alert {
            display: flex;
            gap: 12px;
            padding: 12px 16px;
            background: rgba(59, 130, 246, 0.08);
            border-radius: 10px;
            font-size: 0.8rem;
            color: #475569;
        }

        .info-alert i {
            color: #3b82f6;
            font-size: 20px;
            flex-shrink: 0;
        }

        .info-alert code {
            background: rgba(59, 130, 246, 0.15);
            padding: 2px 6px;
            border-radius: 4px;
            color: #1d4ed8;
        }

        .upload-zone {
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            transition: all 0.2s;
        }

        .upload-zone:hover {
            border-color: #3b82f6;
        }

        .upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            cursor: pointer;
            text-align: center;
        }

        .upload-label i {
            font-size: 40px;
            color: #94a3b8;
            margin-bottom: 8px;
        }

        .upload-text {
            font-weight: 500;
            color: #475569;
        }

        .upload-hint {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .file-name-display {
            text-align: center;
            padding: 8px;
            font-size: 0.85rem;
            color: #10b981;
            font-weight: 500;
        }

        .file-name-display:empty {
            display: none;
        }

        .btn-import {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px;
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-import:hover {
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
        }

        .btn-import i {
            font-size: 20px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('importFile').addEventListener('change', function () {
            const fileName = this.files[0]?.name || '';
            document.getElementById('fileNameDisplay').textContent = fileName ? '📄 ' + fileName : '';
        });
    </script>
@endpush