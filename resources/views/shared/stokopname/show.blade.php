@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
    $isAdmin = $role === 'Admin';
    $isPending = $opname->status === 'pending';
@endphp

@extends($layoutPath)
@section('title','Detail Stock Opname')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('stokopname.index') }}">Stock Opname</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner {{ $opname->status === 'approved' ? 'success' : ($opname->status === 'rejected' ? 'danger' : 'warning') }}">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge"><i class="material-symbols-rounded">inventory</i> Stock Opname</span>
                    <h2 class="welcome-title">{{ $opname->tanggal->format('d F Y') }}</h2>
                    <p class="welcome-subtitle">{{ $opname->details->count() }} item • Dibuat oleh {{ $opname->creator->name }}</p>
                </div>
                <div class="welcome-stats">
                    <a href="{{ route('stokopname.index') }}" class="stat-pill"><i class="material-symbols-rounded">arrow_back</i><span>Kembali</span></a>
                    @if($isPending && $isAdmin)
                        <form action="{{ route('admin.stokopname.reject', $opname->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menolak stock opname ini?')">@csrf<button type="submit" class="stat-pill reject"><i class="material-symbols-rounded">cancel</i><span>Tolak</span></button></form>
                        <form action="{{ route('admin.stokopname.approve', $opname->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Pastikan data sudah benar. Lanjutkan approval?')">@csrf<button type="submit" class="stat-pill approve"><i class="material-symbols-rounded">check_circle</i><span>Setujui</span></button></form>
                    @endif
                </div>
            </div>
            <div class="welcome-illustration">
                <div class="status-badge-large">
                    @if($opname->status === 'approved')<i class="material-symbols-rounded">check_circle</i><span>APPROVED</span>
                    @elseif($opname->status === 'rejected')<i class="material-symbols-rounded">cancel</i><span>REJECTED</span>
                    @else<i class="material-symbols-rounded">schedule</i><span>PENDING</span>@endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Info Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="info-card">
            <div class="info-icon primary"><i class="material-symbols-rounded">person</i></div>
            <div class="info-content"><span class="info-label">Dibuat Oleh</span><span class="info-value">{{ $opname->creator->name }}</span><span class="info-meta">{{ $opname->creator->role->nama_role }}</span></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-card">
            <div class="info-icon info"><i class="material-symbols-rounded">inventory_2</i></div>
            <div class="info-content"><span class="info-label">Jumlah Item</span><span class="info-value">{{ $opname->details->count() }}</span><span class="info-meta">item obat</span></div>
        </div>
    </div>
    @if($opname->status !== 'pending')
    <div class="col-md-4">
        <div class="info-card {{ $opname->status === 'approved' ? 'success-bg' : 'danger-bg' }}">
            <div class="info-icon {{ $opname->status === 'approved' ? 'success' : 'danger' }}"><i class="material-symbols-rounded">{{ $opname->status === 'approved' ? 'verified' : 'cancel' }}</i></div>
            <div class="info-content"><span class="info-label">{{ $opname->status === 'approved' ? 'Disetujui' : 'Ditolak' }} Oleh</span><span class="info-value">{{ $opname->approver->name ?? '-' }}</span><span class="info-meta">{{ $opname->approved_at?->format('d/m/Y H:i') }}</span></div>
        </div>
    </div>
    @endif
</div>

{{-- Detail Table --}}
<div class="card pro-card">
    <div class="card-header pro-card-header">
        <div class="header-left">
            <div class="header-icon primary"><i class="material-symbols-rounded">list_alt</i></div>
            <div><h6 class="header-title">Detail Perubahan Stok</h6><p class="header-subtitle">{{ $opname->details->count() }} item</p></div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table pro-table mb-0">
                <thead><tr><th>Lokasi</th><th>Nama Obat</th><th class="text-center">Stok Sistem</th><th class="text-center">Stok Fisik</th><th class="text-center">Selisih</th><th>Catatan</th></tr></thead>
                <tbody>
                    @foreach ($opname->details as $detail)
                    @php $diff = $detail->physical_qty - $detail->system_qty; @endphp
                    <tr class="{{ $diff != 0 ? 'row-warning' : '' }}">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <i class="material-symbols-rounded text-secondary">location_on</i>
                                <span class="fw-bold">{{ $detail->obat->lokasi_rak ?: 'Tanpa Rak' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="item-icon"><i class="material-symbols-rounded">medication</i></div>
                                <div><span class="fw-bold d-block">{{ $detail->obat->nama_obat }}</span><span class="text-xs text-secondary">{{ $detail->obat->kode_obat }}</span></div>
                            </div>
                        </td>
                        <td class="text-center"><span class="qty-badge">{{ $detail->system_qty }}</span></td>
                        <td class="text-center"><span class="qty-badge">{{ $detail->physical_qty }}</span></td>
                        <td class="text-center">
                            @if($diff > 0)<span class="diff-badge success"><i class="material-symbols-rounded">arrow_upward</i> +{{ $diff }}</span>
                            @elseif($diff < 0)<span class="diff-badge danger"><i class="material-symbols-rounded">arrow_downward</i> {{ $diff }}</span>
                            @else<span class="diff-badge neutral">0</span>@endif
                        </td>
                        <td class="text-secondary">{{ $detail->notes ?: '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
:root { --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6; --primary: #8b5cf6; --secondary: #64748b; }
.welcome-banner { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 16px; padding: 2rem; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; }
.welcome-banner.success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
.welcome-banner.danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0 0 16px; }
.welcome-stats { display: flex; gap: 10px; flex-wrap: wrap; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; text-decoration: none; border: none; cursor: pointer; transition: all 0.2s; }
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; }
.stat-pill.reject { background: rgba(239,68,68,0.8); }
.stat-pill.approve { background: rgba(16,185,129,0.9); }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); }
.status-badge-large { display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 1rem; background: rgba(255,255,255,0.15); border-radius: 12px; }
.status-badge-large i { font-size: 32px; color: white; }
.status-badge-large span { font-size: 0.7rem; font-weight: 700; color: white; text-transform: uppercase; letter-spacing: 1px; }
.info-card { background: white; border-radius: 12px; padding: 1.25rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
.info-card.success-bg { background: rgba(16,185,129,0.06); }
.info-card.danger-bg { background: rgba(239,68,68,0.06); }
.info-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.info-icon i { font-size: 24px; color: white; }
.info-icon.primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.info-icon.info { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.info-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
.info-icon.danger { background: linear-gradient(135deg, #ef4444, #dc2626); }
.info-content { display: flex; flex-direction: column; }
.info-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; font-weight: 600; }
.info-value { font-size: 1rem; font-weight: 600; color: #1e293b; }
.info-meta { font-size: 0.75rem; color: var(--secondary); }
.pro-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.06); overflow: hidden; }
.pro-card-header { padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; }
.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
.header-icon i { color: white; font-size: 20px; }
.header-icon.primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.header-title { font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 0; }
.pro-table { margin: 0; }
.pro-table thead { background: linear-gradient(135deg, #1e293b, #334155); }
.pro-table th { font-size: 0.7rem; font-weight: 600; color: white; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border: none; }
.pro-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.pro-table tbody tr:hover { background: #f8fafc; }
.pro-table tbody tr.row-warning { background: rgba(245,158,11,0.04); }
.item-icon { width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.item-icon i { color: white; font-size: 18px; }
.qty-badge { font-size: 0.85rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; background: #f1f5f9; color: #1e293b; }
.diff-badge { display: inline-flex; align-items: center; gap: 2px; font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 6px; }
.diff-badge i { font-size: 14px; }
.diff-badge.success { background: rgba(16,185,129,0.1); color: var(--success); }
.diff-badge.danger { background: rgba(239,68,68,0.1); color: var(--danger); }
.diff-badge.neutral { background: #f1f5f9; color: var(--secondary); }
@media (max-width: 768px) { .welcome-banner { flex-direction: column; text-align: center; } .welcome-illustration { display: none; } .welcome-stats { justify-content: center; } }
</style>
@endpush
@endsection