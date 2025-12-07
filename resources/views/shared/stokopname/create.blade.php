@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
    $rakList = $obats->keys()->toArray();
@endphp

@extends($layoutPath)
@section('title','Input Stock Opname')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('stokopname.index') }}">Stock Opname</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Input</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge"><i class="fas fa-clipboard-check"></i> Stock Opname</span>
                    <h2 class="welcome-title">Stock Opname Bulanan</h2>
                    <p class="welcome-subtitle">Input stok fisik untuk pengecekan bulanan - {{ now()->isoFormat('MMMM Y') }}</p>
                </div>
                <a href="{{ route('stokopname.index') }}" class="stat-pill"><i class="fas fa-arrow-left"></i><span>Kembali</span></a>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="fas fa-boxes"></i></div>
                <div class="floating-icon icon-2"><i class="fas fa-tasks"></i></div>
            </div>
        </div>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show text-white mb-4" role="alert">
        <span class="alert-icon"><i class="fas fa-exclamation-circle align-middle"></i></span>
        <span class="alert-text"><strong>Terdapat kesalahan:</strong>
            <ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@endif

{{-- Rak Navigation Tabs --}}
<div class="rak-nav-container mb-3">
    <div class="rak-nav-header">
        <span class="rak-nav-label"><i class="fas fa-warehouse"></i> Navigasi Rak</span>
        <div class="rak-nav-actions">
            <button type="button" class="rak-expand-btn" id="expandAllBtn" title="Expand Semua">
                <i class="fas fa-expand-alt"></i>
            </button>
            <button type="button" class="rak-expand-btn" id="collapseAllBtn" title="Collapse Semua">
                <i class="fas fa-compress-alt"></i>
            </button>
        </div>
    </div>
    <div class="rak-tabs" id="rakTabs">
        <button type="button" class="rak-tab active" data-rak="all">
            <span class="rak-name">Semua</span>
            <span class="rak-count" id="allRakCount">0</span>
        </button>
        @foreach($rakList as $rak)
        <button type="button" class="rak-tab" data-rak="{{ $rak ?: 'tanpa-rak' }}">
            <span class="rak-name">{{ $rak ?: 'Tanpa Rak' }}</span>
            <span class="rak-count">{{ count($obats[$rak]) }}</span>
        </button>
        @endforeach
    </div>
</div>

{{-- Search & Filter Bar --}}
<div class="search-filter-bar sticky-top">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Cari nama obat atau kode..." autocomplete="off">
        <button type="button" id="clearSearch" class="clear-btn" style="display:none;">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="sort-dropdown">
        <select id="sortSelect" class="sort-select">
            <option value="rak-asc">Urutkan: Rak A-Z</option>
            <option value="rak-desc">Urutkan: Rak Z-A</option>
            <option value="nama-asc">Urutkan: Nama A-Z</option>
            <option value="nama-desc">Urutkan: Nama Z-A</option>
            <option value="stok-asc">Urutkan: Stok Terendah</option>
            <option value="stok-desc">Urutkan: Stok Tertinggi</option>
        </select>
    </div>
    <div class="filter-pills">
        <button type="button" class="filter-pill active" data-filter="all">
            <i class="fas fa-list"></i>
            <span>Semua</span>
            <span class="count" id="allCount">0</span>
        </button>
        <button type="button" class="filter-pill" data-filter="pending">
            <i class="fas fa-clock"></i>
            <span>Belum</span>
            <span class="count" id="pendingCount">0</span>
        </button>
        <button type="button" class="filter-pill" data-filter="discrepancy">
            <i class="fas fa-exclamation-triangle"></i>
            <span>Selisih</span>
            <span class="count" id="discrepancyCount">0</span>
        </button>
        <button type="button" class="filter-pill" data-filter="match">
            <i class="fas fa-check-circle"></i>
            <span>Sesuai</span>
            <span class="count" id="matchCount">0</span>
        </button>
    </div>
</div>

{{-- Progress Bar --}}
<div class="progress-section mb-4">
    <div class="progress-info">
        <span class="progress-label">Progress Input</span>
        <span class="progress-value"><span id="completedCount">0</span> / <span id="totalCount">0</span> item</span>
    </div>
    <div class="progress-bar-track">
        <div class="progress-bar-fill" id="progressBar" style="width: 0%"></div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="quick-actions mb-3">
    <button type="button" class="quick-action-btn" id="autoFillBtn" title="Isi semua dengan nilai sistem">
        <i class="fas fa-magic"></i> Auto-Fill Sistem
    </button>
    <button type="button" class="quick-action-btn secondary" id="clearAllBtn" title="Kosongkan semua input">
        <i class="fas fa-eraser"></i> Reset Input
    </button>
    <div class="keyboard-hint">
        <kbd>Tab</kbd> / <kbd>Enter</kbd> pindah kolom &bull; <kbd>↑</kbd><kbd>↓</kbd> navigasi baris
    </div>
</div>

{{-- Form --}}
<form action="{{ route('stokopname.store') }}" method="POST" id="stockOpnameForm">
    @csrf
    
    {{-- Grouped by Rak --}}
    @foreach ($obats as $rak => $items)
    <div class="rak-section" data-rak-group="{{ $rak ?: 'tanpa-rak' }}">
        <div class="rak-section-header" data-toggle="collapse" data-target="#rak-{{ Str::slug($rak ?: 'tanpa-rak') }}">
            <div class="rak-section-info">
                <span class="rak-icon"><i class="fas fa-th-large"></i></span>
                <span class="rak-section-title">{{ $rak ?: 'Tanpa Rak' }}</span>
                <span class="rak-item-count">{{ count($items) }} item</span>
            </div>
            <div class="rak-section-stats">
                <span class="rak-stat pending"><i class="fas fa-clock"></i> <span class="rak-pending-count">{{ count($items) }}</span></span>
                <span class="rak-stat match"><i class="fas fa-check"></i> <span class="rak-match-count">0</span></span>
                <span class="rak-stat discrepancy"><i class="fas fa-exclamation"></i> <span class="rak-discrepancy-count">0</span></span>
            </div>
            <i class="fas fa-chevron-down rak-collapse-icon"></i>
        </div>
        <div class="rak-section-body" id="rak-{{ Str::slug($rak ?: 'tanpa-rak') }}">
            <div class="table-responsive">
                <table class="table pro-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th><i class="fas fa-pills"></i> Obat</th>
                            <th class="text-center" style="width: 100px;"><i class="fas fa-database"></i> Sistem</th>
                            <th class="text-center" style="width: 130px;"><i class="fas fa-hand-holding"></i> Fisik</th>
                            <th class="text-center" style="width: 80px;"><i class="fas fa-exchange-alt"></i> Selisih</th>
                            <th style="width: 200px;"><i class="fas fa-sticky-note"></i> Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $obat)
                        <tr class="stock-row" 
                            data-obat-id="{{ $obat->id }}"
                            data-nama="{{ strtolower($obat->nama_obat) }}" 
                            data-kode="{{ strtolower($obat->kode_obat ?? '') }}"
                            data-rak="{{ strtolower($rak ?? '') }}"
                            data-rak-group="{{ $rak ?: 'tanpa-rak' }}"
                            data-system-qty="{{ $obat->total_stok ?? 0 }}"
                            data-status="pending">
                            <td class="text-center"><span class="row-number"></span></td>
                            <td>
                                <div class="obat-info">
                                    <span class="obat-name">{{ $obat->nama_obat }}</span>
                                    <span class="obat-code">{{ $obat->kode_obat }}</span>
                                </div>
                            </td>
                            <td class="text-center"><span class="system-badge">{{ $obat->total_stok ?? 0 }}</span></td>
                            <td class="text-center">
                                <input type="number" 
                                       name="physical_qty[{{ $obat->id }}]" 
                                       class="form-control stock-input text-center" 
                                       min="0" 
                                       required 
                                       value="{{ old('physical_qty.'.$obat->id, '') }}"
                                       placeholder="0">
                            </td>
                            <td class="text-center">
                                <span class="diff-badge" data-diff="0">-</span>
                            </td>
                            <td>
                                <input type="text" 
                                       name="notes[{{ $obat->id }}]" 
                                       class="form-control note-input" 
                                       maxlength="255" 
                                       placeholder="Catatan..." 
                                       value="{{ old('notes.'.$obat->id) }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
    
    {{-- Empty State --}}
    <div class="empty-state" id="emptyState" style="display: none;">
        <div class="empty-icon"><i class="fas fa-search"></i></div>
        <h6>Tidak ada hasil</h6>
        <p>Coba kata kunci lain atau reset filter</p>
        <button type="button" class="btn-reset" onclick="resetFilters()">Reset Filter</button>
    </div>

    <div class="form-actions">
        <a href="{{ route('stokopname.index') }}" class="btn-outline-pro"><i class="fas fa-times"></i> Batal</a>
        <button type="submit" class="btn-pro success" id="submitBtn">
            <i class="fas fa-paper-plane"></i> 
            Kirim Approval
        </button>
    </div>
</form>

@push('styles')
<style>
:root { --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6; --primary: #8b5cf6; --secondary: #64748b; }

/* Welcome Banner */
.welcome-banner { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 16px; padding: 2rem; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; }
.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0 0 16px; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; text-decoration: none; transition: all 0.2s; }
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: white; font-size: 20px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

/* Rak Navigation */
.rak-nav-container { background: white; border-radius: 14px; padding: 12px 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
.rak-nav-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
.rak-nav-label { font-size: 0.75rem; font-weight: 600; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px; }
.rak-nav-actions { display: flex; gap: 6px; }
.rak-expand-btn { background: #f1f5f9; border: none; padding: 6px 10px; border-radius: 6px; cursor: pointer; color: var(--secondary); transition: all 0.2s; }
.rak-expand-btn:hover { background: var(--primary); color: white; }
.rak-tabs { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 4px; scrollbar-width: thin; }
.rak-tabs::-webkit-scrollbar { height: 4px; }
.rak-tabs::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }
.rak-tab { display: flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; font-size: 0.8rem; font-weight: 500; color: var(--secondary); cursor: pointer; white-space: nowrap; transition: all 0.2s; }
.rak-tab:hover { background: #f8fafc; border-color: var(--primary); }
.rak-tab.active { background: var(--primary); border-color: var(--primary); color: white; }
.rak-tab.active .rak-count { background: rgba(255,255,255,0.2); }
.rak-count { font-size: 0.7rem; padding: 2px 6px; border-radius: 10px; background: #f1f5f9; }

/* Search & Filter Bar */
.search-filter-bar { background: white; border-radius: 14px; padding: 16px 20px; display: flex; gap: 12px; align-items: center; margin-bottom: 16px; box-shadow: 0 4px 16px rgba(0,0,0,0.06); z-index: 100; flex-wrap: wrap; }
.search-box { flex: 1; min-width: 200px; display: flex; align-items: center; gap: 10px; background: #f8fafc; border-radius: 10px; padding: 10px 14px; border: 1px solid #e2e8f0; transition: all 0.2s; }
.search-box:focus-within { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(139,92,246,0.1); }
.search-box i { color: var(--secondary); font-size: 14px; }
.search-box input { flex: 1; border: none; background: none; font-size: 0.9rem; outline: none; }
.clear-btn { background: none; border: none; cursor: pointer; color: var(--secondary); padding: 2px; display: flex; }
.clear-btn:hover { color: var(--danger); }

.sort-dropdown { min-width: 180px; }
.sort-select { width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.85rem; color: #1e293b; background: white; cursor: pointer; outline: none; }
.sort-select:focus { border-color: var(--primary); }

.filter-pills { display: flex; gap: 6px; flex-wrap: wrap; }
.filter-pill { display: inline-flex; align-items: center; gap: 4px; padding: 8px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 500; border: 1px solid #e2e8f0; background: white; color: var(--secondary); cursor: pointer; transition: all 0.2s; }
.filter-pill:hover { background: #f8fafc; }
.filter-pill.active { background: var(--primary); border-color: var(--primary); color: white; }
.filter-pill.active .count { background: rgba(255,255,255,0.2); }
.filter-pill i { font-size: 12px; }
.filter-pill .count { font-size: 0.65rem; padding: 2px 5px; border-radius: 10px; background: #f1f5f9; }

/* Progress Section */
.progress-section { background: white; border-radius: 12px; padding: 16px 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
.progress-info { display: flex; justify-content: space-between; margin-bottom: 10px; }
.progress-label { font-size: 0.8rem; color: var(--secondary); font-weight: 500; }
.progress-value { font-size: 0.85rem; font-weight: 600; color: var(--primary); }
.progress-bar-track { height: 8px; background: #f1f5f9; border-radius: 4px; overflow: hidden; }
.progress-bar-fill { height: 100%; background: linear-gradient(90deg, var(--primary), #a78bfa); border-radius: 4px; transition: width 0.3s ease; }

/* Quick Actions */
.quick-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
.quick-action-btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 16px; border-radius: 10px; font-size: 0.8rem; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s; background: linear-gradient(135deg, var(--primary), #7c3aed); color: white; }
.quick-action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(139,92,246,0.3); }
.quick-action-btn.secondary { background: #f1f5f9; color: var(--secondary); }
.quick-action-btn.secondary:hover { background: #e2e8f0; box-shadow: none; }
.keyboard-hint { margin-left: auto; font-size: 0.75rem; color: var(--secondary); }
.keyboard-hint kbd { background: #f1f5f9; padding: 3px 6px; border-radius: 4px; font-size: 0.7rem; font-family: inherit; }

/* Rak Section */
.rak-section { background: white; border-radius: 14px; margin-bottom: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); overflow: hidden; transition: all 0.2s; }
.rak-section.hidden { display: none; }
.rak-section-header { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: linear-gradient(135deg, #f8fafc, #f1f5f9); cursor: pointer; user-select: none; transition: all 0.2s; }
.rak-section-header:hover { background: linear-gradient(135deg, #f1f5f9, #e2e8f0); }
.rak-section-info { display: flex; align-items: center; gap: 10px; }
.rak-icon { width: 32px; height: 32px; border-radius: 8px; background: var(--primary); display: flex; align-items: center; justify-content: center; }
.rak-icon i { color: white; font-size: 14px; }
.rak-section-title { font-size: 0.95rem; font-weight: 600; color: #1e293b; }
.rak-item-count { font-size: 0.75rem; color: var(--secondary); background: white; padding: 3px 8px; border-radius: 12px; }
.rak-section-stats { display: flex; gap: 12px; }
.rak-stat { display: flex; align-items: center; gap: 4px; font-size: 0.75rem; font-weight: 500; }
.rak-stat.pending { color: var(--warning); }
.rak-stat.match { color: var(--success); }
.rak-stat.discrepancy { color: var(--danger); }
.rak-collapse-icon { font-size: 14px; color: var(--secondary); transition: transform 0.2s; }
.rak-section.collapsed .rak-collapse-icon { transform: rotate(-90deg); }
.rak-section-body { transition: all 0.3s; }
.rak-section.collapsed .rak-section-body { display: none; }

/* Table */
.pro-table { margin: 0; }
.pro-table thead { background: #faf5ff; }
.pro-table th { font-size: 0.7rem; font-weight: 600; color: #000000; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 14px; border: none; white-space: nowrap; }
.pro-table th i { font-size: 12px; margin-right: 4px; }
.pro-table td { padding: 10px 14px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.pro-table tbody tr { transition: background 0.15s; }
.pro-table tbody tr:hover { background: #faf5ff; }
.pro-table tbody tr.hidden { display: none; }

.row-number { font-size: 0.75rem; color: var(--secondary); font-weight: 500; display: inline-block; min-width: 24px; }
.obat-info { display: flex; flex-direction: column; }
.obat-name { font-weight: 600; color: #1e293b; font-size: 0.85rem; }
.obat-code { font-size: 0.7rem; color: var(--secondary); }
.system-badge { font-size: 0.85rem; font-weight: 700; padding: 5px 10px; border-radius: 8px; background: #f1f5f9; color: #1e293b; display: inline-block; }
.stock-input { width: 80px; height: 38px; border-radius: 8px; border: 2px solid #e2e8f0; text-align: center; font-weight: 600; font-size: 0.95rem; transition: all 0.2s; }
.stock-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(139,92,246,0.15); outline: none; }
.stock-input.filled { background: #faf5ff; border-color: #c4b5fd; }
.stock-input.match { background: rgba(16,185,129,0.1); border-color: var(--success); }
.stock-input.discrepancy { background: rgba(239,68,68,0.1); border-color: var(--danger); }
.diff-badge { font-size: 0.8rem; font-weight: 700; padding: 4px 8px; border-radius: 6px; display: inline-block; }
.diff-badge[data-diff="0"] { background: #f1f5f9; color: var(--secondary); }
.diff-badge.positive { background: rgba(16,185,129,0.12); color: var(--success); }
.diff-badge.negative { background: rgba(239,68,68,0.12); color: var(--danger); }
.note-input { height: 38px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.8rem; padding: 0 10px; width: 100%; }
.note-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(139,92,246,0.1); outline: none; }

/* Row states */
.stock-row.row-match { background: rgba(16,185,129,0.04); }
.stock-row.row-discrepancy { background: rgba(239,68,68,0.04); }
.stock-row.row-completed td:first-child .row-number { background: var(--success); color: white; padding: 4px 8px; border-radius: 6px; }

/* Empty State */
.empty-state { text-align: center; padding: 3rem; background: white; border-radius: 14px; margin-bottom: 16px; }
.empty-icon { width: 70px; height: 70px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
.empty-icon i { font-size: 28px; color: var(--secondary); }
.empty-state h6 { color: #475569; margin-bottom: 6px; font-size: 1rem; }
.empty-state p { font-size: 0.85rem; color: var(--secondary); margin: 0 0 16px; }
.btn-reset { background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 500; cursor: pointer; }

/* Form Actions */
.form-actions { display: flex; justify-content: space-between; gap: 12px; padding: 1.5rem 0; position: sticky; bottom: 0; background: linear-gradient(to top, #f8fafc 80%, transparent); }
.btn-pro { display: inline-flex; align-items: center; gap: 6px; padding: 12px 24px; background: linear-gradient(135deg, #1e293b, #334155); color: white; font-size: 0.9rem; font-weight: 600; border-radius: 12px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-pro.success { background: linear-gradient(135deg, #10b981, #059669); }
.btn-pro:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.2); }
.btn-pro i { font-size: 16px; }
.btn-outline-pro { display: inline-flex; align-items: center; gap: 6px; padding: 12px 24px; background: white; color: var(--secondary); font-size: 0.9rem; font-weight: 600; border-radius: 12px; border: 2px solid #e2e8f0; text-decoration: none; transition: all 0.2s; }
.btn-outline-pro:hover { background: #f8fafc; color: #1e293b; border-color: #cbd5e1; }

@media (max-width: 768px) { 
    .welcome-banner { flex-direction: column; text-align: center; } 
    .welcome-illustration { display: none; }
    .search-filter-bar { flex-direction: column; }
    .search-box, .sort-dropdown { min-width: 100%; width: 100%; }
    .filter-pills { width: 100%; justify-content: center; }
    .quick-actions { flex-direction: column; align-items: stretch; }
    .keyboard-hint { display: none; }
    .rak-section-stats { display: none; }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearSearch');
    const sortSelect = document.getElementById('sortSelect');
    const filterPills = document.querySelectorAll('.filter-pill');
    const rakTabs = document.querySelectorAll('.rak-tab');
    const rakSections = document.querySelectorAll('.rak-section');
    const stockRows = document.querySelectorAll('.stock-row');
    const stockInputs = document.querySelectorAll('.stock-input');
    const emptyState = document.getElementById('emptyState');
    
    let currentFilter = 'all';
    let currentRak = 'all';
    let searchTerm = '';
    
    // Initialize
    updateRowNumbers();
    updateCounts();
    updateProgress();
    document.getElementById('allRakCount').textContent = stockRows.length;
    
    // Rak section collapse toggle
    document.querySelectorAll('.rak-section-header').forEach(header => {
        header.addEventListener('click', function() {
            this.closest('.rak-section').classList.toggle('collapsed');
        });
    });
    
    // Expand/Collapse All
    document.getElementById('expandAllBtn').addEventListener('click', () => {
        rakSections.forEach(s => s.classList.remove('collapsed'));
    });
    document.getElementById('collapseAllBtn').addEventListener('click', () => {
        rakSections.forEach(s => s.classList.add('collapsed'));
    });
    
    // Rak tab navigation
    rakTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            rakTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentRak = this.dataset.rak;
            filterRows();
            
            // Scroll to rak section if specific rak
            if (currentRak !== 'all') {
                const targetSection = document.querySelector(`[data-rak-group="${currentRak}"]`);
                if (targetSection) {
                    targetSection.classList.remove('collapsed');
                    targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });
    
    // Search functionality
    searchInput.addEventListener('input', function() {
        searchTerm = this.value.toLowerCase().trim();
        clearBtn.style.display = searchTerm ? 'flex' : 'none';
        filterRows();
    });
    
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        searchTerm = '';
        clearBtn.style.display = 'none';
        filterRows();
        searchInput.focus();
    });
    
    // Sort functionality
    sortSelect.addEventListener('change', function() {
        sortRows(this.value);
    });
    
    // Filter pills
    filterPills.forEach(pill => {
        pill.addEventListener('click', function() {
            filterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            filterRows();
        });
    });
    
    // Stock input handling
    stockInputs.forEach((input, index) => {
        input.addEventListener('input', function() {
            handleStockInput(this);
        });
        
        // Keyboard navigation
        input.addEventListener('keydown', function(e) {
            const allInputs = Array.from(stockInputs).filter(inp => !inp.closest('tr').classList.contains('hidden'));
            const currentIndex = allInputs.indexOf(this);
            
            if (e.key === 'Enter' || (e.key === 'Tab' && !e.shiftKey)) {
                e.preventDefault();
                if (currentIndex < allInputs.length - 1) {
                    allInputs[currentIndex + 1].focus();
                    allInputs[currentIndex + 1].select();
                }
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (currentIndex < allInputs.length - 1) {
                    allInputs[currentIndex + 1].focus();
                    allInputs[currentIndex + 1].select();
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (currentIndex > 0) {
                    allInputs[currentIndex - 1].focus();
                    allInputs[currentIndex - 1].select();
                }
            }
        });
        
        // Trigger initial calculation if has value
        if (input.value) {
            handleStockInput(input);
        }
    });
    
    function handleStockInput(input) {
        const row = input.closest('tr');
        const section = input.closest('.rak-section');
        const systemQty = parseInt(row.dataset.systemQty) || 0;
        const physicalQty = input.value === '' ? null : parseInt(input.value);
        const diffBadge = row.querySelector('.diff-badge');
        
        input.classList.remove('filled', 'match', 'discrepancy');
        row.classList.remove('row-match', 'row-discrepancy', 'row-completed');
        
        if (physicalQty !== null) {
            input.classList.add('filled');
            row.classList.add('row-completed');
            
            const diff = physicalQty - systemQty;
            diffBadge.textContent = diff === 0 ? '0' : (diff > 0 ? '+' + diff : diff);
            diffBadge.dataset.diff = diff;
            diffBadge.classList.remove('positive', 'negative');
            
            if (diff === 0) {
                input.classList.add('match');
                row.classList.add('row-match');
                row.dataset.status = 'match';
            } else {
                input.classList.add('discrepancy');
                row.classList.add('row-discrepancy');
                row.dataset.status = 'discrepancy';
                diffBadge.classList.add(diff > 0 ? 'positive' : 'negative');
            }
        } else {
            row.dataset.status = 'pending';
            diffBadge.textContent = '-';
            diffBadge.dataset.diff = 0;
        }
        
        updateCounts();
        updateProgress();
        updateRakSectionStats(section);
        filterRows();
    }
    
    function filterRows() {
        let visibleCount = 0;
        let visibleSections = new Set();
        
        stockRows.forEach(row => {
            const nama = row.dataset.nama || '';
            const kode = row.dataset.kode || '';
            const rak = row.dataset.rak || '';
            const rakGroup = row.dataset.rakGroup || '';
            const status = row.dataset.status;
            
            // Search match
            const matchesSearch = !searchTerm || 
                nama.includes(searchTerm) || 
                kode.includes(searchTerm) || 
                rak.includes(searchTerm);
            
            // Rak match
            const matchesRak = currentRak === 'all' || rakGroup === currentRak;
            
            // Filter match
            let matchesFilter = true;
            if (currentFilter === 'pending') matchesFilter = status === 'pending';
            else if (currentFilter === 'discrepancy') matchesFilter = status === 'discrepancy';
            else if (currentFilter === 'match') matchesFilter = status === 'match';
            
            if (matchesSearch && matchesFilter && matchesRak) {
                row.classList.remove('hidden');
                visibleCount++;
                visibleSections.add(row.closest('.rak-section'));
            } else {
                row.classList.add('hidden');
            }
        });
        
        // Show/hide rak sections
        rakSections.forEach(section => {
            if (currentRak !== 'all') {
                section.classList.toggle('hidden', section.dataset.rakGroup !== currentRak);
            } else {
                section.classList.toggle('hidden', !visibleSections.has(section));
            }
        });
        
        // Show/hide empty state
        emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        
        updateRowNumbers();
    }
    
    function sortRows(sortBy) {
        rakSections.forEach(section => {
            const tbody = section.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('.stock-row'));
            
            rows.sort((a, b) => {
                let valA, valB;
                switch(sortBy) {
                    case 'nama-asc':
                        return a.dataset.nama.localeCompare(b.dataset.nama);
                    case 'nama-desc':
                        return b.dataset.nama.localeCompare(a.dataset.nama);
                    case 'stok-asc':
                        return parseInt(a.dataset.systemQty) - parseInt(b.dataset.systemQty);
                    case 'stok-desc':
                        return parseInt(b.dataset.systemQty) - parseInt(a.dataset.systemQty);
                    default:
                        return 0;
                }
            });
            
            rows.forEach(row => tbody.appendChild(row));
        });
        
        // For rak sorting, we need to sort sections
        if (sortBy === 'rak-asc' || sortBy === 'rak-desc') {
            const container = document.getElementById('stockOpnameForm');
            const sections = Array.from(rakSections);
            
            sections.sort((a, b) => {
                const rakA = a.dataset.rakGroup || '';
                const rakB = b.dataset.rakGroup || '';
                return sortBy === 'rak-asc' 
                    ? rakA.localeCompare(rakB) 
                    : rakB.localeCompare(rakA);
            });
            
            sections.forEach(section => container.insertBefore(section, document.getElementById('emptyState')));
        }
        
        updateRowNumbers();
    }
    
    function updateRowNumbers() {
        let num = 0;
        stockRows.forEach(row => {
            if (!row.classList.contains('hidden')) {
                num++;
                row.querySelector('.row-number').textContent = num;
            }
        });
    }
    
    function updateCounts() {
        let pending = 0, discrepancy = 0, match = 0;
        
        stockRows.forEach(row => {
            const status = row.dataset.status;
            if (status === 'pending') pending++;
            else if (status === 'discrepancy') discrepancy++;
            else if (status === 'match') match++;
        });
        
        document.getElementById('allCount').textContent = stockRows.length;
        document.getElementById('pendingCount').textContent = pending;
        document.getElementById('discrepancyCount').textContent = discrepancy;
        document.getElementById('matchCount').textContent = match;
    }
    
    function updateProgress() {
        let completed = 0;
        stockRows.forEach(row => {
            if (row.dataset.status !== 'pending') completed++;
        });
        
        const total = stockRows.length;
        const percentage = total > 0 ? (completed / total) * 100 : 0;
        
        document.getElementById('completedCount').textContent = completed;
        document.getElementById('totalCount').textContent = total;
        document.getElementById('progressBar').style.width = percentage + '%';
    }
    
    function updateRakSectionStats(section) {
        if (!section) return;
        const rows = section.querySelectorAll('.stock-row');
        let pending = 0, match = 0, discrepancy = 0;
        
        rows.forEach(row => {
            const status = row.dataset.status;
            if (status === 'pending') pending++;
            else if (status === 'match') match++;
            else if (status === 'discrepancy') discrepancy++;
        });
        
        section.querySelector('.rak-pending-count').textContent = pending;
        section.querySelector('.rak-match-count').textContent = match;
        section.querySelector('.rak-discrepancy-count').textContent = discrepancy;
    }
    
    // Quick Actions
    document.getElementById('autoFillBtn').addEventListener('click', function() {
        if (!confirm('Isi semua input dengan nilai stok sistem?')) return;
        stockInputs.forEach(input => {
            const row = input.closest('tr');
            input.value = row.dataset.systemQty;
            handleStockInput(input);
        });
    });
    
    document.getElementById('clearAllBtn').addEventListener('click', function() {
        if (!confirm('Reset semua input?')) return;
        stockInputs.forEach(input => {
            input.value = '';
            handleStockInput(input);
        });
    });
    
    // Global reset function
    window.resetFilters = function() {
        searchInput.value = '';
        searchTerm = '';
        clearBtn.style.display = 'none';
        filterPills.forEach(p => p.classList.remove('active'));
        filterPills[0].classList.add('active');
        rakTabs.forEach(t => t.classList.remove('active'));
        rakTabs[0].classList.add('active');
        currentFilter = 'all';
        currentRak = 'all';
        sortSelect.value = 'rak-asc';
        filterRows();
    };
    
    // Initialize rak section stats
    rakSections.forEach(section => updateRakSectionStats(section));
    
    // Form submission
    document.getElementById('stockOpnameForm').addEventListener('submit', function(e) {
        const pendingCount = document.getElementById('pendingCount').textContent;
        if (parseInt(pendingCount) > 0) {
            if (!confirm(`Masih ada ${pendingCount} item yang belum diinput. Lanjutkan kirim?`)) {
                e.preventDefault();
                return;
            }
        }
        if (!confirm('Pastikan data stok fisik sudah benar. Lanjutkan kirim untuk approval?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
@endsection