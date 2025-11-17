@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title','Riwayat Stock Opname')

@section('content')
<div class="container-fluid py-4">
    <x-content-header title="Riwayat Stock Opname" subtitle="Daftar semua stock opname yang telah dilakukan">
        @if(in_array($role, ['Admin', 'Karyawan']))
        <a href="{{ route('stokopname.create') }}" class="btn bg-gradient-primary mb-0">
            <i class="material-symbols-rounded text-sm me-1">add</i> Input Stock Opname
        </a>
        @endif
    </x-content-header>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded">check_circle</i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Daftar Stock Opname</h6>
                    <p class="text-sm">Total {{ $opnames->total() }} record</p>
                </div>
                @if($role === 'Admin')
                <a href="{{ route('admin.stokopname.pending') }}" class="btn btn-sm bg-gradient-warning mb-0">
                    <i class="material-symbols-rounded text-sm me-1">pending</i> Pending Approval
                </a>
                @endif
            </div>
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
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Disetujui</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($opnames as $opname)
                        <tr>
                            <td>
                                <div class="d-flex px-3 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ $opname->tanggal->format('d/m/Y') }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $opname->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold mb-0">{{ $opname->creator->name }}</p>
                                <p class="text-xs text-secondary mb-0">{{ $opname->creator->role->nama_role }}</p>
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge badge-sm bg-gradient-info">{{ $opname->total_items }} item</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge badge-sm {{ $opname->status_badge }}">
                                    {{ strtoupper($opname->status) }}
                                </span>
                            </td>
                            <td>
                                @if($opname->approver)
                                    <p class="text-sm font-weight-bold mb-0">{{ $opname->approver->name }}</p>
                                    <p class="text-xs text-secondary mb-0">{{ $opname->approved_at?->format('d/m/Y H:i') }}</p>
                                @else
                                    <p class="text-xs text-secondary mb-0">-</p>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <a href="{{ route('stokopname.show', $opname->id) }}" 
                                   class="btn btn-sm bg-gradient-primary mb-0"
                                   data-bs-toggle="tooltip" title="Lihat Detail">
                                    <i class="material-symbols-rounded text-sm">visibility</i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="material-symbols-rounded text-secondary" style="font-size: 3rem;">inventory_2</i>
                                <p class="text-secondary mb-0">Belum ada data stock opname</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $opnames->links() }}
        </div>
    </div>
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