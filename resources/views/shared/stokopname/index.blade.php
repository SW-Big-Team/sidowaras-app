@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
    $isAdmin = $role === 'Admin';
@endphp

@extends($layoutPath)
@section('title','Riwayat Stock Opname')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Stock Opname</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Riwayat</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-dark border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                                    <i class="material-symbols-rounded text-dark">inventory</i>
                                </div>
                                <div>
                                    <h4 class="mb-0 text-white font-weight-bolder">Riwayat Stock Opname</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">Daftar semua stock opname yang telah dilakukan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <div class="d-flex gap-2 justify-content-md-end">
                                @if($isAdmin)
                                    <a href="{{ route('admin.stokopname.pending') }}" class="btn bg-warning mb-0">
                                        <i class="material-symbols-rounded align-middle me-1" style="font-size: 1.2rem;">pending_actions</i>
                                        Pending
                                    </a>
                                @endif
                                @if(in_array($role, ['Admin', 'Karyawan']))
                                    <a href="{{ route('stokopname.create') }}" class="btn bg-white mb-0">
                                        <i class="material-symbols-rounded align-middle me-1" style="font-size: 1.2rem;">add_circle</i>
                                        Input Stock Opname
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="material-symbols-rounded me-2">check_circle</i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Summary Card --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-dark shadow-dark text-center border-radius-md me-3">
                            <i class="material-symbols-rounded opacity-10 text-white">fact_check</i>
                        </div>
                        <div>
                            <p class="text-xs mb-0 text-uppercase font-weight-bold">Total Stock Opname</p>
                            <h4 class="font-weight-bolder mb-0">{{ $opnames->total() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white pb-0">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h6 class="mb-0">Daftar Stock Opname</h6>
                    <span class="text-xs text-secondary">{{ $opnames->total() }} record ditemukan</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <form method="GET" action="{{ route('stokopname.index') }}" class="d-flex align-items-center gap-2 flex-nowrap">
                        {{-- Search Input with Icon --}}
                        <div class="input-group" style="width: 220px;">
                            <span class="input-group-text bg-white" style="border-radius: 8px 0 0 8px; border-right: 0;">
                                <i class="material-symbols-rounded text-secondary" style="font-size: 18px;">search</i>
                            </span>
                            <input type="text" 
                                   name="search" 
                                   value="{{ $search ?? '' }}" 
                                   class="form-control ps-0" 
                                   style="border-radius: 0 8px 8px 0; border-left: 0;"
                                   placeholder="Cari nama, status...">
                            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                        </div>
                        {{-- Search Button --}}
                        <button type="submit" class="btn bg-gradient-dark mb-0 px-3" style="border-radius: 8px;">
                            <i class="material-symbols-rounded" style="font-size: 18px;">search</i>
                        </button>
                        {{-- Clear Filter --}}
                        @if($search ?? false)
                            <a href="{{ route('stokopname.index') }}" class="btn btn-outline-secondary mb-0 px-3" style="border-radius: 8px;" title="Hapus Filter">
                                <i class="material-symbols-rounded" style="font-size: 18px;">close</i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead class="bg-gradient-dark">
                        <tr>
                            <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-4">Tanggal</th>
                            <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Dibuat Oleh</th>
                            <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Jumlah Item</th>
                            <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Status</th>
                            <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Disetujui</th>
                            <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($opnames as $opname)
                        <tr class="border-bottom">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-sm icon-shape bg-gradient-dark shadow-dark text-center border-radius-md me-2">
                                        <i class="material-symbols-rounded text-white text-xs">calendar_today</i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-sm">{{ $opname->tanggal->format('d M Y') }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $opname->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm bg-gradient-dark rounded-circle me-2">
                                        <span class="text-white text-xs font-weight-bold">{{ substr($opname->creator->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-weight-bold mb-0">{{ $opname->creator->name }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $opname->creator->role->nama_role }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-sm bg-light text-dark border">
                                    <i class="fas fa-box me-1"></i> {{ $opname->total_items }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($opname->status === 'approved')
                                    <span class="badge badge-sm bg-gradient-success">
                                        <i class="material-symbols-rounded text-xs align-middle">check_circle</i>
                                        APPROVED
                                    </span>
                                @elseif($opname->status === 'rejected')
                                    <span class="badge badge-sm bg-gradient-danger">
                                        <i class="material-symbols-rounded text-xs align-middle">cancel</i>
                                        REJECTED
                                    </span>
                                @else
                                    <span class="badge badge-sm bg-gradient-warning">
                                        <i class="material-symbols-rounded text-xs align-middle">schedule</i>
                                        PENDING
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($opname->approver)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xs bg-gradient-success rounded-circle me-2">
                                            <span class="text-white text-xxs font-weight-bold">{{ substr($opname->approver->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-weight-bold mb-0">{{ $opname->approver->name }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $opname->approved_at?->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-xs text-secondary mb-0">-</p>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('stokopname.show', $opname->id) }}" 
                                   class="btn btn-link text-dark font-weight-bold text-xs px-2 mb-0"
                                   data-bs-toggle="tooltip" 
                                   title="Lihat Detail">
                                    Detail <i class="fas fa-chevron-right text-xs ms-1"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="icon icon-xl icon-shape bg-gradient-dark shadow-dark rounded-circle mb-4">
                                        <i class="material-symbols-rounded text-white opacity-10" style="font-size: 3rem;">inventory_2</i>
                                    </div>
                                    <h6 class="text-secondary font-weight-normal">Belum ada data stock opname</h6>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                {{-- Left: Per Page Selector --}}
                <div class="d-flex align-items-center gap-2">
                    <span class="text-xs text-secondary">Tampilkan</span>
                    <select class="form-select form-select-sm border rounded-2 px-2 py-1" 
                            style="width: auto; min-width: 65px;" 
                            onchange="window.location.href='{{ route('stokopname.index') }}?per_page='+this.value+'&search={{ $search ?? '' }}'">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span class="text-xs text-secondary">data per halaman</span>
                </div>
                {{-- Center: Info --}}
                <p class="text-xs text-secondary mb-0">
                    <span class="fw-bold">{{ $opnames->firstItem() ?? 0 }}</span> - 
                    <span class="fw-bold">{{ $opnames->lastItem() ?? 0 }}</span> dari 
                    <span class="fw-bold">{{ $opnames->total() }}</span> data
                </p>
                {{-- Right: Pagination --}}
                <div>
                    {{ $opnames->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush