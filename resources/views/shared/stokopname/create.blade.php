@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
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
                    <span class="greeting-badge"><i class="material-symbols-rounded">add_task</i> Stock Opname</span>
                    <h2 class="welcome-title">Stock Opname Bulanan</h2>
                    <p class="welcome-subtitle">Input stok fisik untuk pengecekan bulanan - {{ now()->isoFormat('MMMM Y') }}</p>
                </div>
                <a href="{{ route('stokopname.index') }}" class="stat-pill"><i class="material-symbols-rounded">arrow_back</i><span>Kembali</span></a>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">inventory</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">fact_check</i></div>
            </div>
        </div>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show text-white mb-4" role="alert">
        <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
        <span class="alert-text"><strong>Terdapat kesalahan:</strong>
            <ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@endif

{{-- Metric Card --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="metric-card primary">
            <div class="metric-icon"><i class="material-symbols-rounded">inventory_2</i></div>
            <div class="metric-content"><span class="metric-label">Total Item</span><h3 class="metric-value">{{ $obats->sum(fn($items) => $items->count()) }}</h3><span class="metric-subtext">Items obat terdaftar</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
</div>

{{-- Form --}}
<form action="{{ route('stokopname.store') }}" method="POST" id="stockOpnameForm">
    @csrf
    <div class="accordion-wrapper">
        @foreach ($obats as $rak => $items)
            <div class="card pro-card mb-3">
                <div class="accordion-header" data-bs-toggle="collapse" data-bs-target="#collapse-{{ Str::slug($rak ?: 'tanpa-lokasi') }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                    <div class="header-left">
                        <div class="accordion-icon"><i class="material-symbols-rounded">shelves</i></div>
                        <div><h6 class="accordion-title">Rak: {{ $rak ?: 'Tanpa Lokasi' }}</h6><p class="accordion-subtitle">{{ $items->count() }} item obat</p></div>
                    </div>
                    <div class="header-right">
                        <span class="item-count">{{ $items->count() }}</span>
                        <i class="material-symbols-rounded accordion-arrow">expand_more</i>
                    </div>
                </div>

                <div id="collapse-{{ Str::slug($rak ?: 'tanpa-lokasi') }}" class="collapse {{ $loop->first ? 'show' : '' }}">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table pro-table mb-0">
                                <thead><tr><th><i class="material-symbols-rounded">medication</i> Nama Obat</th><th class="text-center"><i class="material-symbols-rounded">database</i> Stok Sistem</th><th class="text-center"><i class="material-symbols-rounded">inventory</i> Stok Fisik</th><th><i class="material-symbols-rounded">edit_note</i> Catatan</th></tr></thead>
                                <tbody>
                                    @foreach ($items as $obat)
                                    <tr class="stock-row">
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="item-icon"><i class="material-symbols-rounded">medication</i></div>
                                                <div><span class="fw-bold d-block">{{ $obat->nama_obat }}</span><span class="text-xs text-secondary">{{ $obat->kode_obat }}</span></div>
                                            </div>
                                        </td>
                                        <td class="text-center"><span class="system-badge">{{ $obat->total_stok ?? 0 }}</span></td>
                                        <td class="text-center">
                                            <input type="number" name="physical_qty[{{ $obat->id }}]" class="form-control stock-input text-center" min="0" required value="{{ old('physical_qty.'.$obat->id, 0) }}" data-system-qty="{{ $obat->total_stok ?? 0 }}">
                                        </td>
                                        <td><input type="text" name="notes[{{ $obat->id }}]" class="form-control note-input" maxlength="255" placeholder="Catatan..." value="{{ old('notes.'.$obat->id) }}"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="form-actions">
        <a href="{{ route('stokopname.index') }}" class="btn-outline-pro"><i class="material-symbols-rounded">close</i> Batal</a>
        <button type="submit" class="btn-pro success"><i class="material-symbols-rounded">send</i> Kirim Approval</button>
    </div>
</form>

@push('styles')
<style>
:root { --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6; --primary: #8b5cf6; --secondary: #64748b; }
.welcome-banner { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 16px; padding: 2rem; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; }
.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0 0 16px; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; text-decoration: none; transition: all 0.2s; }
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.metric-card { background: white; border-radius: 16px; padding: 1.25rem; display: flex; gap: 1rem; position: relative; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
.metric-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.metric-icon i { font-size: 26px; color: white; }
.metric-card.primary .metric-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.metric-content { flex: 1; }
.metric-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; font-weight: 600; }
.metric-value { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 4px 0; }
.metric-subtext { font-size: 0.75rem; color: var(--secondary); }
.metric-glow { position: absolute; top: -50%; right: -50%; width: 100%; height: 200%; border-radius: 50%; opacity: 0.08; background: var(--primary); }
.pro-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.06); overflow: hidden; }
.accordion-header { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; cursor: pointer; transition: background 0.2s; }
.accordion-header:hover { background: #f8fafc; }
.header-left { display: flex; align-items: center; gap: 12px; }
.accordion-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #1e293b, #334155); display: flex; align-items: center; justify-content: center; }
.accordion-icon i { color: white; font-size: 20px; }
.accordion-title { font-size: 0.95rem; font-weight: 600; color: #1e293b; margin: 0; }
.accordion-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 0; }
.header-right { display: flex; align-items: center; gap: 12px; }
.item-count { font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 6px; background: #f1f5f9; color: var(--secondary); }
.accordion-arrow { color: var(--secondary); transition: transform 0.3s; }
[aria-expanded="true"] .accordion-arrow, .accordion-header:not(.collapsed) .accordion-arrow { transform: rotate(180deg); }
.pro-table { margin: 0; }
.pro-table thead { background: linear-gradient(135deg, #f8fafc, #f1f5f9); }
.pro-table th { font-size: 0.7rem; font-weight: 600; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border: none; }
.pro-table th i { font-size: 14px; vertical-align: middle; margin-right: 4px; }
.pro-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.stock-row.row-success { background: rgba(16,185,129,0.06); }
.stock-row.row-danger { background: rgba(239,68,68,0.06); }
.item-icon { width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.item-icon i { color: white; font-size: 18px; }
.system-badge { font-size: 0.85rem; font-weight: 700; padding: 6px 12px; border-radius: 8px; background: #f1f5f9; color: #1e293b; }
.stock-input { width: 100px; height: 38px; border-radius: 8px; border: 1px solid #e2e8f0; text-align: center; font-weight: 600; transition: all 0.2s; }
.stock-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(139,92,246,0.15); }
.note-input { height: 38px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; }
.note-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(139,92,246,0.15); }
.form-actions { display: flex; justify-content: space-between; gap: 12px; padding: 1.5rem 0; }
.btn-pro { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: linear-gradient(135deg, #1e293b, #334155); color: white; font-size: 0.875rem; font-weight: 500; border-radius: 10px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-pro.success { background: linear-gradient(135deg, #10b981, #059669); }
.btn-pro:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
.btn-pro i { font-size: 18px; }
.btn-outline-pro { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: white; color: var(--secondary); font-size: 0.875rem; font-weight: 500; border-radius: 10px; border: 1px solid #e2e8f0; text-decoration: none; transition: all 0.2s; }
.btn-outline-pro:hover { background: #f8fafc; color: #1e293b; }
@media (max-width: 768px) { .welcome-banner { flex-direction: column; text-align: center; } .welcome-illustration { display: none; } }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('stockOpnameForm');
    const inputs = document.querySelectorAll('.stock-input');
    
    inputs.forEach(input => {
        checkVariance(input);
        input.addEventListener('input', function() { checkVariance(this); });
    });

    function checkVariance(input) {
        const systemQty = parseInt(input.dataset.systemQty || 0);
        const physicalQty = input.value === '' ? 0 : parseInt(input.value);
        const row = input.closest('tr');
        row.classList.remove('row-success', 'row-danger');
        if (physicalQty > systemQty) { row.classList.add('row-success'); } 
        else if (physicalQty < systemQty) { row.classList.add('row-danger'); }
    }
    
    form.addEventListener('submit', function(e) {
        if (!confirm('Pastikan data stok fisik sudah benar. Lanjutkan?')) { e.preventDefault(); }
    });
});
</script>
@endpush
@endsection