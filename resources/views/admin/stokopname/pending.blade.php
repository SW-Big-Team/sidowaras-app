@extends('layouts.admin.app')
@section('title', 'Stock Opname Pending')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Stock Opname</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Pending Approval</li>
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
                                    <i class="material-symbols-rounded text-dark">fact_check</i>
                                </div>
                                <div>
                                    <h4 class="mb-0 text-white font-weight-bolder">Stock Opname Pending</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">Daftar stock opname yang memerlukan persetujuan Admin</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <a href="{{ route('admin.dashboard') }}" class="btn bg-white mb-0">
                                <i class="material-symbols-rounded align-middle me-1" style="font-size: 1.2rem;">arrow_back</i>
                                Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="material-symbols-rounded me-2">check_circle</i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-start">
                <i class="material-symbols-rounded me-2">error</i>
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    {{-- Content --}}
    @if($pendingOpnames->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="icon icon-xl icon-shape bg-gradient-dark shadow-dark rounded-circle mb-4 mx-auto">
                    <i class="material-symbols-rounded text-white opacity-10" style="font-size: 3rem;">task_alt</i>
                </div>
                <h5 class="text-dark font-weight-bold">Tidak Ada Stock Opname Pending</h5>
                <p class="text-sm text-secondary mb-0">Semua stock opname sudah diproses</p>
            </div>
        </div>
    @else
        {{-- Summary Card --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center border-radius-md me-3">
                                <i class="material-symbols-rounded opacity-10 text-white">pending_actions</i>
                            </div>
                            <div>
                                <p class="text-xs mb-0 text-uppercase font-weight-bold">Total Pending</p>
                                <h4 class="font-weight-bolder mb-0">{{ $pendingOpnames->total() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white pb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Daftar Stock Opname</h6>
                    <span class="badge bg-gradient-warning">{{ $pendingOpnames->total() }} menunggu</span>
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
                                <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingOpnames as $opname)
                            <tr class="border-bottom">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="icon icon-sm icon-shape bg-gradient-dark shadow-dark text-center border-radius-md me-2">
                                            <i class="material-symbols-rounded text-white text-xs">calendar_today</i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-sm">{{ $opname->tanggal->format('d M Y') }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $opname->tanggal->isoFormat('dddd') }}</p>
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
                                            <p class="text-xs text-secondary mb-0">{{ $opname->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-sm bg-light text-dark border">
                                        <i class="fas fa-box me-1"></i> {{ $opname->details->count() }} item
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-sm bg-gradient-warning">
                                        <i class="material-symbols-rounded text-xs align-middle">schedule</i>
                                        PENDING
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('stokopname.show', $opname->id) }}" 
                                           class="btn btn-link text-dark px-2 mb-0"
                                           data-bs-toggle="tooltip" 
                                           title="Lihat Detail">
                                            <i class="material-symbols-rounded text-sm">visibility</i>
                                        </a>
                                        <form action="{{ route('admin.stokopname.approve', $opname->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Setujui stock opname ini? Stok akan disesuaikan otomatis.')">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-link text-success px-2 mb-0"
                                                    data-bs-toggle="tooltip" 
                                                    title="Setujui">
                                                <i class="material-symbols-rounded text-sm">check_circle</i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.stokopname.reject', $opname->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Tolak stock opname ini?')">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-link text-danger px-2 mb-0"
                                                    data-bs-toggle="tooltip" 
                                                    title="Tolak">
                                                <i class="material-symbols-rounded text-sm">cancel</i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if($pendingOpnames->hasPages())
                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex justify-content-end">
                        {{ $pendingOpnames->links() }}
                    </div>
                </div>
            @endif
        </div>
    @endif
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