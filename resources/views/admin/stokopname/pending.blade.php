@extends('layouts.admin.app')
@section('title', 'Stock Opname Pending')

@section('content')
<div class="container-fluid py-4">
    <x-content-header title="Stock Opname Menunggu Approval" subtitle="Daftar stock opname yang memerlukan persetujuan Admin">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary mb-0">
            <i class="material-symbols-rounded text-sm me-1">arrow_back</i> Dashboard
        </a>
    </x-content-header>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded">check_circle</i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded">error</i></span>
            <span class="alert-text">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if($pendingOpnames->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="material-symbols-rounded text-secondary" style="font-size: 4rem;">checklist</i>
                <h5 class="text-secondary mt-3">Tidak ada stock opname yang menunggu approval</h5>
                <p class="text-sm text-muted">Semua stock opname sudah diproses</p>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header pb-0">
                <h6>Daftar Stock Opname Pending</h6>
                <p class="text-sm">Total {{ $pendingOpnames->total() }} stock opname menunggu approval</p>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibuat Oleh</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Item</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingOpnames as $opname)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $opname->tanggal->format('d/m/Y') }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $opname->tanggal->isoFormat('dddd') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ $opname->creator->name }}</p>
                                    <p class="text-xs text-secondary mb-0">{{ $opname->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-sm bg-gradient-info">{{ $opname->details->count() }} item</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-sm {{ $opname->status_badge }}">{{ strtoupper($opname->status) }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('stokopname.show', $opname->id) }}" 
                                       class="btn btn-sm bg-gradient-primary mb-0 me-2"
                                       data-bs-toggle="tooltip" title="Lihat Detail">
                                        <i class="material-symbols-rounded text-sm">visibility</i>
                                    </a>
                                    <form action="{{ route('admin.stokopname.approve', $opname->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm bg-gradient-success mb-0"
                                                data-bs-toggle="tooltip" title="Setujui"
                                                onclick="return confirm('Setujui stock opname ini? Stok akan disesuaikan otomatis.')">
                                            <i class="material-symbols-rounded text-sm">check</i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.stokopname.reject', $opname->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm bg-gradient-danger mb-0"
                                                data-bs-toggle="tooltip" title="Tolak"
                                                onclick="return confirm('Tolak stock opname ini?')">
                                            <i class="material-symbols-rounded text-sm">close</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $pendingOpnames->links() }}
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush