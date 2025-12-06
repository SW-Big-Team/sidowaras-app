@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title', 'Detail Pembelian')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('pembelian.index') }}">Transaksi</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail Pembelian</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge"><i class="material-symbols-rounded">receipt_long</i> Detail Pembelian</span>
                    <h2 class="welcome-title">{{ $pembelian->no_faktur }}</h2>
                    <p class="welcome-subtitle">{{ $pembelian->tgl_pembelian->format('d F Y, H:i') }} • {{ $pembelian->stokBatches->count() }} item</p>
                </div>
                <a href="{{ route('pembelian.index') }}" class="stat-pill"><i class="material-symbols-rounded">arrow_back</i><span>Kembali</span></a>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">inventory</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">receipt</i></div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show text-white mb-4" role="alert">
        <span class="alert-icon"><i class="material-symbols-rounded align-middle">check_circle</i></span>
        <span class="alert-text"><strong>Sukses!</strong> {{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show text-white mb-4" role="alert">
        <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
        <span class="alert-text"><strong>Gagal!</strong><ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@endif

{{-- Info Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="info-card">
            <div class="info-icon primary"><i class="material-symbols-rounded">local_shipping</i></div>
            <div class="info-content"><span class="info-label">Supplier</span><span class="info-value">{{ $pembelian->nama_pengirim }}</span><span class="info-meta">{{ $pembelian->no_telepon_pengirim ?? '-' }}</span></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-card">
            <div class="info-icon {{ $pembelian->metode_pembayaran == 'tunai' ? 'success' : ($pembelian->metode_pembayaran == 'termin' ? 'warning' : 'info') }}">
                <i class="material-symbols-rounded">{{ $pembelian->metode_pembayaran == 'tunai' ? 'payments' : ($pembelian->metode_pembayaran == 'termin' ? 'calendar_month' : 'credit_card') }}</i>
            </div>
            <div class="info-content"><span class="info-label">Metode Pembayaran</span><span class="info-value">{{ ucfirst($pembelian->metode_pembayaran) }}</span><span class="info-meta">Pembayaran valid</span></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-card">
            <div class="info-icon success"><i class="material-symbols-rounded">attach_money</i></div>
            <div class="info-content"><span class="info-label">Total Harga</span><span class="info-value text-success">Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</span><span class="info-meta">{{ $pembelian->stokBatches->count() }} item</span></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-card">
            <div class="info-icon secondary"><i class="material-symbols-rounded">person</i></div>
            <div class="info-content"><span class="info-label">Dibuat oleh</span><span class="info-value">{{ $pembelian->user->nama_lengkap ?? $pembelian->user->name ?? '-' }}</span><span class="info-meta">{{ $pembelian->tgl_pembelian->format('d M Y') }}</span></div>
        </div>
    </div>
</div>

{{-- Detail Item Obat --}}
<div class="card pro-card mb-4">
    <div class="card-header pro-card-header">
        <div class="header-left">
            <div class="header-icon success"><i class="material-symbols-rounded">medication</i></div>
            <div><h6 class="header-title">Detail Item Obat</h6><p class="header-subtitle">{{ $pembelian->stokBatches->count() }} item</p></div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table pro-table mb-0">
                <thead><tr><th>Obat</th><th class="text-end">Harga Beli</th><th class="text-center">Jumlah</th><th class="text-end">Subtotal</th><th class="text-center">Kadaluarsa</th></tr></thead>
                <tbody>
                    @forelse($pembelian->stokBatches as $batch)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="item-icon"><i class="material-symbols-rounded">medication</i></div>
                                <span class="fw-bold">{{ $batch->obat->nama_obat ?? 'Obat Dihapus' }}</span>
                            </div>
                        </td>
                        <td class="text-end text-secondary">Rp {{ number_format($batch->harga_beli, 0, ',', '.') }}</td>
                        <td class="text-center"><span class="qty-badge">{{ $batch->jumlah_masuk }}</span></td>
                        <td class="text-end fw-bold">Rp {{ number_format($batch->harga_beli * $batch->jumlah_masuk, 0, ',', '.') }}</td>
                        <td class="text-center"><span class="date-badge">{{ \Carbon\Carbon::parse($batch->tgl_kadaluarsa)->format('d M Y') }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-5"><div class="empty-state"><i class="material-symbols-rounded">inventory_2</i><p>Tidak ada item obat</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Detail Pembayaran Termin --}}
@if($pembelian->metode_pembayaran == 'termin')
@php
    $total_terbayar = $pembelian->pembayaranTermin->sum('jumlah_bayar');
    $sisa_utang = $pembelian->total_harga - $total_terbayar;
@endphp
<div class="card pro-card mb-4">
    <div class="card-header pro-card-header">
        <div class="header-left">
            <div class="header-icon warning"><i class="material-symbols-rounded">payments</i></div>
            <div><h6 class="header-title">Detail Pembayaran Termin</h6><p class="header-subtitle">{{ $pembelian->pembayaranTermin->count() }} cicilan</p></div>
        </div>
        @if($sisa_utang > 0.01)
            <button type="button" class="btn-pro success" data-bs-toggle="modal" data-bs-target="#modalBayarTermin"><i class="material-symbols-rounded">attach_money</i> Bayar Cicilan</button>
        @endif
    </div>
    <div class="card-body p-0">
        @if($pembelian->pembayaranTermin->isNotEmpty())
            <div class="table-responsive">
                <table class="table pro-table mb-0">
                    <thead><tr><th class="text-center">Termin Ke</th><th class="text-end">Total Dibayar</th><th class="text-center">Jatuh Tempo</th><th class="text-center">Tgl Bayar</th><th class="text-center">Status</th><th>Keterangan</th></tr></thead>
                    <tbody>
                        @foreach($pembelian->pembayaranTermin->sortBy('termin_ke') as $termin)
                            <tr>
                                <td class="text-center"><span class="fw-bold">{{ $termin->termin_ke }}</span></td>
                                <td class="text-end">Rp {{ number_format($termin->jumlah_bayar, 0, ',', '.') }}</td>
                                <td class="text-center"><span class="date-badge">{{ $termin->tgl_jatuh_tempo->format('d M Y') }}</span></td>
                                <td class="text-center">{{ $termin->tgl_bayar ? \Carbon\Carbon::parse($termin->tgl_bayar)->format('d M Y') : '-' }}</td>
                                <td class="text-center">
                                    @if($termin->status == 'lunas')<span class="status-badge success"><i class="material-symbols-rounded">check_circle</i> Lunas</span>
                                    @else<span class="status-badge danger"><i class="material-symbols-rounded">pending</i> Belum Lunas</span>@endif
                                </td>
                                <td class="text-secondary text-truncate" style="max-width: 150px;">{{ $termin->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="payment-summary-footer">
                <div class="summary-item"><span>Total Terbayar</span><span class="text-success fw-bold">Rp {{ number_format($total_terbayar, 0, ',', '.') }}</span></div>
                <div class="summary-item"><span>Sisa Utang</span><span class="text-danger fw-bold">Rp {{ number_format($sisa_utang, 0, ',', '.') }}</span></div>
            </div>
        @else
            <div class="p-4 text-center"><p class="text-sm text-secondary mb-0">Tidak ada data termin untuk pembelian ini.</p></div>
        @endif
    </div>
</div>

{{-- Modal Pembayaran --}}
@if($sisa_utang > 0.01)
<div class="modal fade" id="modalBayarTermin" tabindex="-1" aria-labelledby="modalBayarTerminLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pro-modal">
            <div class="pro-modal-header warning"><h5 class="modal-title"><i class="material-symbols-rounded">attach_money</i> Bayar Cicilan Termin</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <form action="{{ route('pembelian.bayarTermin', $pembelian->uuid) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group-modern mb-3"><label class="form-label-modern">Sisa Utang</label><div class="input-modern"><i class="material-symbols-rounded input-icon">money_off</i><input type="text" class="form-control text-danger fw-bold" value="Rp {{ number_format($sisa_utang, 0, ',', '.') }}" readonly></div></div>
                    <div class="form-group-modern mb-3"><label class="form-label-modern">Tanggal Bayar <span class="required">*</span></label><div class="input-modern"><i class="material-symbols-rounded input-icon">calendar_today</i><input type="date" name="tgl_bayar" class="form-control" value="{{ now()->format('Y-m-d') }}" required></div></div>
                    <div class="form-group-modern mb-3"><label class="form-label-modern">Jumlah Bayar <span class="required">*</span></label><div class="input-modern"><i class="material-symbols-rounded input-icon">payments</i><input type="number" name="jumlah_bayar" class="form-control" placeholder="Maks: Rp {{ number_format($sisa_utang, 0, ',', '.') }}" max="{{ $sisa_utang }}" required></div></div>
                    <div class="form-group-modern"><label class="form-label-modern">Keterangan (Opsional)</label><div class="input-modern"><i class="material-symbols-rounded input-icon">notes</i><input type="text" name="keterangan" class="form-control" placeholder="Misal: Transfer Bank ABC"></div></div>
                </div>
                <div class="modal-footer border-top"><button type="button" class="btn-outline-pro btn-sm" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-pro warning btn-sm">Simpan Pembayaran</button></div>
            </form>
        </div>
    </div>
</div>
@endif
@endif

@push('styles')
<style>
:root { --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6; --primary: #8b5cf6; --secondary: #64748b; }
.welcome-banner { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); border-radius: 16px; padding: 2rem; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; }
.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.15); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.7); font-size: 0.9rem; margin: 0 0 16px; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.15); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; text-decoration: none; transition: all 0.2s; }
.stat-pill:hover { background: rgba(255,255,255,0.25); color: white; }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: rgba(255,255,255,0.6); font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.info-card { background: white; border-radius: 12px; padding: 1.25rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
.info-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.info-icon i { font-size: 24px; color: white; }
.info-icon.primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.info-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
.info-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.info-icon.info { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.info-icon.secondary { background: linear-gradient(135deg, #64748b, #475569); }
.info-content { display: flex; flex-direction: column; }
.info-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; font-weight: 600; }
.info-value { font-size: 1rem; font-weight: 600; color: #1e293b; }
.info-meta { font-size: 0.75rem; color: var(--secondary); }
.pro-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.06); overflow: hidden; }
.pro-card-header { padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; }
.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
.header-icon i { color: white; font-size: 20px; }
.header-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
.header-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.header-title { font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 0; }
.pro-table { margin: 0; }
.pro-table thead { background: linear-gradient(135deg, #1e293b, #334155); }
.pro-table th { font-size: 0.7rem; font-weight: 600; color: white; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border: none; }
.pro-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.pro-table tbody tr:hover { background: #f8fafc; }
.item-icon { width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; }
.item-icon i { color: white; font-size: 18px; }
.qty-badge { font-size: 0.85rem; font-weight: 700; color: #1e293b; }
.date-badge { font-size: 0.75rem; color: var(--secondary); }
.status-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; padding: 4px 10px; border-radius: 6px; font-weight: 500; }
.status-badge i { font-size: 14px; }
.status-badge.success { background: rgba(16,185,129,0.1); color: var(--success); }
.status-badge.danger { background: rgba(239,68,68,0.1); color: var(--danger); }
.payment-summary-footer { display: flex; justify-content: flex-end; gap: 2rem; padding: 1rem 1.5rem; background: #f8fafc; border-top: 1px solid #f1f5f9; }
.summary-item { display: flex; gap: 12px; font-size: 0.9rem; }
.btn-pro { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: linear-gradient(135deg, #1e293b, #334155); color: white; font-size: 0.8rem; font-weight: 500; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-pro.success { background: linear-gradient(135deg, #10b981, #059669); }
.btn-pro.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.btn-pro:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
.btn-pro i { font-size: 18px; }
.btn-outline-pro { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: white; color: var(--secondary); font-size: 0.8rem; font-weight: 500; border-radius: 8px; border: 1px solid #e2e8f0; text-decoration: none; transition: all 0.2s; }
.btn-outline-pro:hover { background: #f8fafc; color: #1e293b; }
.pro-modal { border-radius: 16px; border: none; overflow: hidden; }
.pro-modal-header { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; }
.pro-modal-header.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.pro-modal-header h5 { display: flex; align-items: center; gap: 8px; color: white; font-weight: 600; margin: 0; }
.form-group-modern { margin-bottom: 0; }
.form-label-modern { display: block; font-size: 0.7rem; font-weight: 600; color: #475569; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
.form-label-modern .required { color: var(--danger); }
.input-modern { position: relative; }
.input-modern .input-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--secondary); font-size: 18px; z-index: 2; }
.input-modern .form-control { padding-left: 42px; height: 44px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.875rem; transition: all 0.2s; }
.input-modern .form-control:focus { border-color: var(--warning); box-shadow: 0 0 0 3px rgba(245,158,11,0.15); }
.empty-state { display: flex; flex-direction: column; align-items: center; color: var(--secondary); }
.empty-state i { font-size: 48px; margin-bottom: 8px; }
@media (max-width: 768px) { .welcome-banner { flex-direction: column; text-align: center; } .welcome-illustration { display: none; } }
</style>
@endpush

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalBayar = document.getElementById('modalBayarTermin');
    if (modalBayar) {
        const terminList = @json($pembelian->pembayaranTermin); 
        const totalUtang = {{ $pembelian->total_harga }};
        let totalTerbayar = 0;
        terminList.forEach(t => totalTerbayar += parseFloat(t.jumlah_bayar));
        const sisaUtang = totalUtang - totalTerbayar;
        terminList.sort((a, b) => a.termin_ke - b.termin_ke);
        const maxTerminKe = terminList[terminList.length - 1].termin_ke;
        const activeTermin = terminList.find(t => t.status === 'belum_lunas');
        const inputJumlah = modalBayar.querySelector('input[name="jumlah_bayar"]');
        if (activeTermin && activeTermin.termin_ke === maxTerminKe) {
            inputJumlah.value = sisaUtang;
            inputJumlah.setAttribute('min', sisaUtang);
            const helperText = document.createElement('small');
            helperText.className = 'text-danger fw-bold d-block mt-1';
            helperText.innerText = '* Ini termin terakhir. Harap lunasi sisa hutang.';
            if(!inputJumlah.parentNode.querySelector('.text-danger')) { inputJumlah.parentNode.appendChild(helperText); }
        }
    }
});
</script>
@endsection