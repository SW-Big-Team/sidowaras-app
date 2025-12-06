@extends('layouts.admin.app')

@section('title', 'Daftar Supplier')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Data</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Supplier</li>
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
                        <i class="material-symbols-rounded">local_shipping</i>
                        Manajemen Supplier
                    </span>
                    <h2 class="welcome-title">Data Supplier</h2>
                    <p class="welcome-subtitle">Kelola informasi supplier dan pemasok obat untuk apotek Anda.</p>
                </div>
                <div class="welcome-stats">
                    <button type="button" class="stat-pill success" data-bs-toggle="modal" data-bs-target="#supplierModal" data-mode="create">
                        <i class="material-symbols-rounded">add_circle</i>
                        <span>Tambah Supplier</span>
                    </button>
                </div>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">inventory_2</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">storefront</i></div>
                <div class="floating-icon icon-3"><i class="material-symbols-rounded">handshake</i></div>
            </div>
        </div>
    </div>
</div>

{{-- Metric Cards --}}
<div class="row g-3 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="metric-card primary">
            <div class="metric-icon">
                <i class="material-symbols-rounded">inventory_2</i>
            </div>
            <div class="metric-content">
                <span class="metric-label">Total Supplier</span>
                <h3 class="metric-value">{{ $suppliers->total() }}</h3>
                <div class="metric-change neutral">
                    <i class="material-symbols-rounded">storefront</i>
                    <span>Supplier terdaftar</span>
                </div>
            </div>
            <div class="metric-glow"></div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="metric-card success">
            <div class="metric-icon">
                <i class="material-symbols-rounded">check_circle</i>
            </div>
            <div class="metric-content">
                <span class="metric-label">Supplier Aktif</span>
                <h3 class="metric-value">{{ \App\Models\Supplier::where('supplier_status', true)->count() }}</h3>
                <div class="metric-change neutral">
                    <i class="material-symbols-rounded">verified</i>
                    <span>Aktif & terverifikasi</span>
                </div>
            </div>
            <div class="metric-glow"></div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="metric-card secondary">
            <div class="metric-icon">
                <i class="material-symbols-rounded">cancel</i>
            </div>
            <div class="metric-content">
                <span class="metric-label">Supplier Nonaktif</span>
                <h3 class="metric-value">{{ \App\Models\Supplier::where('supplier_status', false)->count() }}</h3>
                <div class="metric-change neutral">
                    <i class="material-symbols-rounded">pause_circle</i>
                    <span>Tidak aktif</span>
                </div>
            </div>
            <div class="metric-glow"></div>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
        <span class="alert-icon"><i class="material-symbols-rounded align-middle">check_circle</i></span>
        <span class="alert-text fw-bold">{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
        <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
        <span class="alert-text"><ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                <h6 class="header-title">Data Supplier</h6>
                <p class="header-subtitle">{{ $suppliers->total() }} supplier terdaftar</p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('admin.supplier.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-nowrap">
                <div class="input-group" style="width: auto;">
                    <span class="input-group-text bg-white" style="border-radius: 8px 0 0 8px; border-right: 0;">
                        <i class="material-symbols-rounded text-secondary" style="font-size: 18px;">filter_list</i>
                    </span>
                    <select name="status" class="form-control form-select-sm" onchange="this.form.submit()" style="min-width: 130px; border-radius: 0 8px 8px 0;">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
                <div class="input-group" style="width: 220px;">
                    <span class="input-group-text bg-white" style="border-radius: 8px 0 0 8px; border-right: 0;">
                        <i class="material-symbols-rounded text-secondary" style="font-size: 18px;">search</i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control ps-0" style="border-radius: 0 8px 8px 0; border-left: 0;" placeholder="Cari supplier...">
                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                </div>
                <button type="submit" class="btn-pro-sm"><i class="material-symbols-rounded">search</i></button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.supplier.index') }}" class="btn-outline-pro-sm" title="Hapus Filter"><i class="material-symbols-rounded">close</i></a>
                @endif
            </form>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table pro-table mb-0">
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Kontak</th>
                        <th>Email & Website</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="supplier-avatar">
                                        <i class="material-symbols-rounded">storefront</i>
                                    </div>
                                    <div>
                                        <span class="fw-bold d-block">{{ $supplier->supplier_name }}</span>
                                        @if($supplier->supplier_address)
                                            <span class="text-xs text-secondary">{{ Str::limit($supplier->supplier_address, 40) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="material-symbols-rounded text-secondary" style="font-size: 16px;">phone</i>
                                    <span class="fw-medium">{{ $supplier->supplier_phone }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="contact-info">
                                    <span class="text-xs"><i class="material-symbols-rounded me-1" style="font-size: 14px;">mail</i>{{ $supplier->supplier_email ?? '-' }}</span>
                                    <span class="text-xs text-secondary"><i class="material-symbols-rounded me-1" style="font-size: 14px;">language</i>{{ $supplier->supplier_website ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.supplier.toggle-status', $supplier->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="status-toggle {{ $supplier->supplier_status ? 'active' : 'inactive' }}" title="Klik untuk mengubah status">
                                        <i class="material-symbols-rounded">{{ $supplier->supplier_status ? 'check_circle' : 'cancel' }}</i>
                                        <span>{{ $supplier->supplier_status ? 'Aktif' : 'Nonaktif' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <button type="button" class="action-btn edit" data-bs-toggle="modal" data-bs-target="#supplierModal" data-mode="edit" data-id="{{ $supplier->id }}" data-name="{{ $supplier->supplier_name }}" data-phone="{{ $supplier->supplier_phone }}" data-address="{{ $supplier->supplier_address }}" data-email="{{ $supplier->supplier_email }}" data-website="{{ $supplier->supplier_website }}" data-logo="{{ $supplier->supplier_logo }}" data-status="{{ $supplier->supplier_status ? 1 : 0 }}" title="Edit">
                                        <i class="material-symbols-rounded">edit</i>
                                    </button>
                                    <form action="{{ route('admin.supplier.destroy', $supplier->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus supplier {{ $supplier->supplier_name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Hapus">
                                            <i class="material-symbols-rounded">delete</i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="material-symbols-rounded">local_shipping</i></div>
                                    <h6>Belum ada data supplier</h6>
                                    <p>Tambahkan supplier baru untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($suppliers->hasPages())
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="text-xs text-secondary">Tampilkan</span>
                    <select class="form-select form-select-sm" style="width: 70px;" onchange="window.location.href='{{ route('admin.supplier.index') }}?per_page='+this.value+'&search={{ request('search') }}&status={{ request('status') }}'">
                        @foreach([10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    <span class="text-xs text-secondary">data</span>
                </div>
                <p class="text-xs text-secondary mb-0">
                    <span class="fw-bold">{{ $suppliers->firstItem() ?? 0 }}</span> - 
                    <span class="fw-bold">{{ $suppliers->lastItem() ?? 0 }}</span> dari 
                    <span class="fw-bold">{{ $suppliers->total() }}</span>
                </p>
                {{ $suppliers->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>

{{-- Modal: Create/Edit Supplier --}}
<div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content pro-modal">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="modal-icon"><i class="material-symbols-rounded">local_shipping</i></div>
                    <h5 class="modal-title" id="supplierModalLabel">Tambah Supplier</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="supplierForm" method="POST" action="{{ route('admin.supplier.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="supplierFormMethod" value="POST">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">Nama Supplier <span class="required">*</span></label>
                                <div class="input-modern">
                                    <i class="material-symbols-rounded input-icon">storefront</i>
                                    <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Nama supplier" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">No. Telepon <span class="required">*</span></label>
                                <div class="input-modern">
                                    <i class="material-symbols-rounded input-icon">phone</i>
                                    <input type="text" class="form-control" name="supplier_phone" id="supplier_phone" placeholder="08xxx" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">Email</label>
                                <div class="input-modern">
                                    <i class="material-symbols-rounded input-icon">mail</i>
                                    <input type="email" class="form-control" name="supplier_email" id="supplier_email" placeholder="email@supplier.com">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">Website</label>
                                <div class="input-modern">
                                    <i class="material-symbols-rounded input-icon">language</i>
                                    <input type="url" class="form-control" name="supplier_website" id="supplier_website" placeholder="https://supplier.com">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="form-label-modern">Alamat</label>
                                <div class="input-modern textarea">
                                    <i class="material-symbols-rounded input-icon">location_on</i>
                                    <textarea class="form-control" name="supplier_address" id="supplier_address" rows="2" placeholder="Alamat lengkap supplier"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">Status</label>
                                <div class="d-flex gap-3 mt-2">
                                    <label class="form-check-inline d-flex align-items-center gap-2">
                                        <input type="radio" name="supplier_status" value="1" class="form-check-input" checked>
                                        <span class="text-sm">Aktif</span>
                                    </label>
                                    <label class="form-check-inline d-flex align-items-center gap-2">
                                        <input type="radio" name="supplier_status" value="0" class="form-check-input">
                                        <span class="text-sm">Non-Aktif</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline-pro" data-bs-dismiss="modal"><i class="material-symbols-rounded">close</i> Batal</button>
                    <button type="submit" class="btn-pro primary" id="supplierSubmitBtn"><i class="material-symbols-rounded">save</i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
:root { --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6; --primary: #8b5cf6; --secondary: #64748b; }

.welcome-banner { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 16px; padding: 2rem; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; }
.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0 0 16px; max-width: 500px; }
.welcome-stats { display: flex; gap: 10px; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s; }
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; transform: translateY(-2px); }
.stat-pill.success { background: rgba(16, 185, 129, 0.6); }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
.floating-icon.icon-3 { animation-delay: 1s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

.metric-card { background: white; border-radius: 16px; padding: 1.25rem; display: flex; gap: 1rem; position: relative; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); transition: all 0.3s ease; }
.metric-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
.metric-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.metric-icon i { font-size: 26px; }
.metric-card.success .metric-icon { background: rgba(16,185,129,0.12); }
.metric-card.success .metric-icon i { color: var(--success); }
.metric-card.primary .metric-icon { background: rgba(139,92,246,0.12); }
.metric-card.primary .metric-icon i { color: var(--primary); }
.metric-card.secondary .metric-icon { background: rgba(100,116,139,0.12); }
.metric-card.secondary .metric-icon i { color: var(--secondary); }
.metric-content { flex: 1; }
.metric-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; font-weight: 600; }
.metric-value { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 4px 0; }
.metric-change { display: flex; align-items: center; gap: 4px; font-size: 0.75rem; font-weight: 500; }
.metric-change i { font-size: 16px; }
.metric-change.neutral { color: var(--secondary); }
.metric-glow { position: absolute; width: 120px; height: 120px; border-radius: 50%; right: -30px; bottom: -30px; opacity: 0.1; }
.metric-card.success .metric-glow { background: var(--success); }
.metric-card.primary .metric-glow { background: var(--primary); }
.metric-card.secondary .metric-glow { background: var(--secondary); }

.pro-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.06); overflow: hidden; }
.pro-card-header { padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; flex-wrap: wrap; gap: 12px; }
.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); display: flex; align-items: center; justify-content: center; }
.header-icon i { color: white; font-size: 20px; }
.header-title { font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 0; }

.btn-pro-sm { display: inline-flex; align-items: center; justify-content: center; padding: 8px 12px; background: linear-gradient(135deg, #1e293b, #475569); color: white; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-pro-sm:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(30,41,59,0.4); }
.btn-pro-sm i { font-size: 18px; }
.btn-outline-pro-sm { display: inline-flex; align-items: center; justify-content: center; padding: 8px 12px; background: white; color: var(--secondary); border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; transition: all 0.2s; }
.btn-outline-pro-sm:hover { background: #f8fafc; color: #1e293b; }
.btn-outline-pro-sm i { font-size: 18px; }

.pro-table { margin: 0; }
.pro-table thead { background: linear-gradient(135deg, #1e293b, #334155); }
.pro-table th { font-size: 0.7rem; font-weight: 600; color: white; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border: none; }
.pro-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.pro-table tbody tr:hover { background: #f8fafc; }

.supplier-avatar { width: 42px; height: 42px; border-radius: 10px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); display: flex; align-items: center; justify-content: center; }
.supplier-avatar i { color: white; font-size: 20px; }

.contact-info { display: flex; flex-direction: column; gap: 2px; }
.contact-info span { display: flex; align-items: center; }

.status-toggle { display: inline-flex; align-items: center; gap: 4px; padding: 5px 12px; border-radius: 6px; border: none; font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.status-toggle i { font-size: 16px; }
.status-toggle.active { background: rgba(16,185,129,0.12); color: var(--success); }
.status-toggle.active:hover { background: var(--success); color: white; }
.status-toggle.inactive { background: rgba(100,116,139,0.12); color: var(--secondary); }
.status-toggle.inactive:hover { background: var(--secondary); color: white; }

.action-buttons { display: flex; gap: 6px; justify-content: center; }
.action-btn { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.2s; }
.action-btn i { font-size: 18px; }
.action-btn.edit { background: rgba(245,158,11,0.12); color: var(--warning); }
.action-btn.edit:hover { background: var(--warning); color: white; }
.action-btn.delete { background: rgba(239,68,68,0.12); color: var(--danger); }
.action-btn.delete:hover { background: var(--danger); color: white; }

.empty-state { text-align: center; padding: 2rem; }
.empty-icon { width: 60px; height: 60px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; }
.empty-icon i { font-size: 28px; color: var(--secondary); }
.empty-state h6 { color: #475569; margin-bottom: 4px; }
.empty-state p { font-size: 0.8rem; color: var(--secondary); margin: 0; }

.pro-modal { border-radius: 16px; border: none; overflow: hidden; }
.pro-modal .modal-header { background: linear-gradient(135deg, #8b5cf6, #7c3aed); padding: 1.25rem 1.5rem; border: none; }
.pro-modal .modal-title { color: white; font-weight: 600; margin: 0; }
.modal-icon { width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; }
.modal-icon i { color: white; font-size: 20px; }
.pro-modal .modal-footer { border-top: 1px solid #f1f5f9; padding: 1rem 1.5rem; }
.pro-modal .btn-close { filter: brightness(0) invert(1); opacity: 0.8; }
.pro-modal .btn-close:hover { opacity: 1; }

.form-group-modern { margin-bottom: 0; }
.form-label-modern { display: block; font-size: 0.75rem; font-weight: 600; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
.form-label-modern .required { color: var(--danger); }
.input-modern { position: relative; }
.input-modern .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--secondary); font-size: 20px; z-index: 2; }
.input-modern.textarea .input-icon { top: 18px; }
.input-modern .form-control { padding-left: 46px; height: 48px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.9rem; transition: all 0.2s; }
.input-modern textarea.form-control { height: auto; padding-top: 12px; }
.input-modern .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(139,92,246,0.15); }

.btn-pro { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; font-size: 0.875rem; font-weight: 500; border-radius: 10px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-pro.primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.btn-pro:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
.btn-pro i { font-size: 18px; }
.btn-outline-pro { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: white; color: var(--secondary); font-size: 0.875rem; font-weight: 500; border-radius: 10px; border: 1px solid #e2e8f0; cursor: pointer; transition: all 0.2s; }
.btn-outline-pro:hover { background: #f8fafc; color: #1e293b; }
.btn-outline-pro i { font-size: 18px; }

@media (max-width: 768px) {
    .welcome-banner { flex-direction: column; text-align: center; }
    .welcome-stats { justify-content: center; }
    .welcome-illustration { display: none; }
    .pro-card-header { flex-direction: column; align-items: stretch; }
}
</style>
@endpush

@push('scripts')
<script>
(function() {
    const modalEl = document.getElementById('supplierModal');
    if (!modalEl) return;
    
    modalEl.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const mode = button?.getAttribute('data-mode') || 'create';
        const form = document.getElementById('supplierForm');
        const methodInput = document.getElementById('supplierFormMethod');
        const titleEl = document.getElementById('supplierModalLabel');
        const submitBtn = document.getElementById('supplierSubmitBtn');

        if (mode === 'edit') {
            const id = button.getAttribute('data-id');
            form.action = "{{ url('adminx/supplier') }}/" + id;
            methodInput.value = 'PUT';
            titleEl.innerHTML = 'Edit Supplier';
            submitBtn.innerHTML = '<i class="material-symbols-rounded">update</i> Update';
            
            document.getElementById('supplier_name').value = button.getAttribute('data-name') || '';
            document.getElementById('supplier_phone').value = button.getAttribute('data-phone') || '';
            document.getElementById('supplier_email').value = button.getAttribute('data-email') || '';
            document.getElementById('supplier_website').value = button.getAttribute('data-website') || '';
            document.getElementById('supplier_address').value = button.getAttribute('data-address') || '';
            
            const status = button.getAttribute('data-status');
            document.querySelectorAll('input[name="supplier_status"]').forEach(r => {
                r.checked = r.value === status;
            });
        } else {
            form.action = "{{ route('admin.supplier.store') }}";
            methodInput.value = 'POST';
            titleEl.innerHTML = 'Tambah Supplier';
            submitBtn.innerHTML = '<i class="material-symbols-rounded">save</i> Simpan';
            
            document.getElementById('supplier_name').value = '';
            document.getElementById('supplier_phone').value = '';
            document.getElementById('supplier_email').value = '';
            document.getElementById('supplier_website').value = '';
            document.getElementById('supplier_address').value = '';
            document.querySelector('input[name="supplier_status"][value="1"]').checked = true;
        }
    });
})();
</script>
@endpush
@endsection