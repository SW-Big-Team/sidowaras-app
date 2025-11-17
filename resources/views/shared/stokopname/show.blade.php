@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title','Approval Stock Opname Obat')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Detail Stock Opname</h1>
        <a href="{{ route('stokopname.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Stock Opname</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Tanggal:</strong> {{ $opname->tanggal->format('d/m/Y') }}</p>
                    <p><strong>Dibuat oleh:</strong> {{ $opname->creator->name }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $opname->status == 'approved' ? 'success' : ($opname->status == 'rejected' ? 'danger' : 'warning') }} fs-6">
                            {{ strtoupper($opname->status) }}
                        </span>
                    </p>
                    @if($opname->status !== 'pending')
                        <p><strong>Disetujui oleh:</strong> {{ $opname->approver->name ?? '-' }}</p>
                    @endif
                </div>
                <div class="col-md-4 text-end">
                    @if($opname->status == 'pending' && Auth::user()->role->nama_role === 'Admin')
                        <div class="d-flex gap-2 justify-content-end">
                            <form action="{{ route('admin.stokopname.reject', $opname->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Yakin ingin menolak stock opname ini?')">
                                    <i class="fas fa-times me-1"></i>Tolak
                                </button>
                            </form>
                            <form action="{{ route('admin.stokopname.approve', $opname->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-success" 
                                        onclick="return confirm('Pastikan data sudah benar. Lanjutkan approval?')">
                                    <i class="fas fa-check me-1"></i>Setujui & Sesuaikan Stok
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Perubahan Stok</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Rak</th>
                            <th>Nama Obat</th>
                            <th class="text-center">Stok Sistem</th>
                            <th class="text-center">Stok Fisik</th>
                            <th class="text-center">Selisih</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($opname->details as $detail)
                        <tr class="{{ $detail->physical_qty != $detail->system_qty ? 'table-warning' : '' }}">
                            <td>{{ $detail->obat->lokasi_rak ?: 'Tanpa Rak' }}</td>
                            <td>
                                {{ $detail->obat->nama_obat }}
                                <div class="text-muted small">{{ $detail->obat->kode_obat }}</div>
                            </td>
                            <td class="text-center fw-bold">{{ $detail->system_qty }}</td>
                            <td class="text-center fw-bold">{{ $detail->physical_qty }}</td>
                            <td class="text-center fw-bold 
                                {{ $detail->physical_qty > $detail->system_qty ? 'text-success' : ($detail->physical_qty < $detail->system_qty ? 'text-danger' : '') }}">
                                {{ $detail->physical_qty - $detail->system_qty }}
                            </td>
                            <td>{{ $detail->notes ?: '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table td, .table th {
        vertical-align: middle;
    }
    .text-success, .text-danger {
        font-weight: 600;
    }
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.85rem;
        }
        .table td, .table th {
            padding: 0.3rem;
        }
    }
</style>
@endpush