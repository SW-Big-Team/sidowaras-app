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
<div class="container-fluid py-4">
    {{-- Action Header --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <a href="{{ route('stokopname.index') }}" class="btn btn-outline-dark btn-sm mb-0">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Riwayat
            </a>
            @if($isPending && $isAdmin)
                <div class="d-flex gap-2">
                    <form action="{{ route('admin.stokopname.reject', $opname->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menolak stock opname ini?')">
                        @csrf
                        <button type="submit" class="btn bg-gradient-danger btn-sm mb-0">
                            <i class="material-symbols-rounded align-middle" style="font-size: 1rem;">cancel</i> Tolak
                        </button>
                    </form>
                    <form action="{{ route('admin.stokopname.approve', $opname->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Pastikan data sudah benar. Lanjutkan approval?')">
                        @csrf
                        <button type="submit" class="btn bg-gradient-success btn-sm mb-0">
                            <i class="material-symbols-rounded align-middle" style="font-size: 1rem;">check_circle</i> Setujui & Sesuaikan Stok
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-11 col-md-12">
            {{-- HEADER: Stock Opname Info --}}
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-gradient-dark p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                                    <i class="material-symbols-rounded text-dark">inventory</i>
                                </div>
                                <div>
                                    <h5 class="mb-0 text-white font-weight-bolder">Detail Stock Opname</h5>
                                    <p class="text-sm text-white opacity-8 mb-0">{{ $opname->tanggal->format('d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end text-start mt-3 mt-md-0">
                            @if($opname->status === 'approved')
                                <span class="badge badge-lg bg-success">
                                    <i class="material-symbols-rounded text-sm align-middle">check_circle</i> APPROVED
                                </span>
                            @elseif($opname->status === 'rejected')
                                <span class="badge badge-lg bg-danger">
                                    <i class="material-symbols-rounded text-sm align-middle">cancel</i> REJECTED
                                </span>
                            @else
                                <span class="badge badge-lg bg-warning">
                                    <i class="material-symbols-rounded text-sm align-middle">schedule</i> PENDING
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- INFO GRID --}}
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border border-radius-lg h-100">
                                <h6 class="text-uppercase text-xs font-weight-bolder text-secondary mb-2">Dibuat Oleh</h6>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm bg-gradient-dark rounded-circle me-2">
                                        <span class="text-white text-xs font-weight-bold">{{ substr($opname->creator->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-dark font-weight-bold text-sm d-block">{{ $opname->creator->name }}</span>
                                        <span class="text-xs text-secondary">{{ $opname->creator->role->nama_role }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border border-radius-lg h-100">
                                <h6 class="text-uppercase text-xs font-weight-bolder text-secondary mb-2">Jumlah Item</h6>
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-sm bg-dark-soft text-dark rounded-circle me-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <span class="text-dark font-weight-bold text-lg">{{ $opname->details->count() }} item obat</span>
                                </div>
                            </div>
                        </div>
                        @if($opname->status !== 'pending')
                            <div class="col-md-4 mb-3">
                                <div class="p-3 border border-radius-lg {{ $opname->status === 'approved' ? 'bg-success-soft' : 'bg-danger-soft' }} h-100">
                                    <h6 class="text-uppercase text-xs font-weight-bolder text-secondary mb-2">
                                        {{ $opname->status === 'approved' ? 'Disetujui Oleh' : 'Ditolak Oleh' }}
                                    </h6>
                                    @if($opname->approver)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-gradient-{{ $opname->status === 'approved' ? 'success' : 'danger' }} rounded-circle me-2">
                                                <span class="text-white text-xs font-weight-bold">{{ substr($opname->approver->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <span class="text-dark font-weight-bold text-sm d-block">{{ $opname->approver->name }}</span>
                                                <span class="text-xs text-secondary">{{ $opname->approved_at?->format('d/m/Y H:i') }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-secondary">-</span>
                                    @endif>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- TABLE: Stock Changes --}}
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white pb-0">
                    <h6 class="mb-0">Detail Perubahan Stok</h6>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-gradient-dark">
                                <tr>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-4">Lokasi</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Nama Obat</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Stok Sistem</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Stok Fisik</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Selisih</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($opname->details as $detail)
                                <tr class="border-bottom {{ $detail->physical_qty != $detail->system_qty ? 'bg-warning-soft' : '' }}">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <i class="material-symbols-rounded text-sm text-secondary me-2">location_on</i>
                                            <span class="text-sm font-weight-bold">{{ $detail->obat->lokasi_rak ?: 'Tanpa Rak' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0 text-sm">{{ $detail->obat->nama_obat }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $detail->obat->kode_obat }}</p>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-sm bg-light text-dark border font-weight-bold">{{ $detail->system_qty }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-sm bg-light text-dark border font-weight-bold">{{ $detail->physical_qty }}</span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $diff = $detail->physical_qty - $detail->system_qty;
                                        @endphp
                                        @if($diff > 0)
                                            <span class="badge badge-sm bg-gradient-success">
                                                <i class="material-symbols-rounded text-xs align-middle">arrow_upward</i> +{{ $diff }}
                                            </span>
                                        @elseif($diff < 0)
                                            <span class="badge badge-sm bg-gradient-danger">
                                                <i class="material-symbols-rounded text-xs align-middle">arrow_downward</i> {{ $diff }}
                                            </span>
                                        @else
                                            <span class="badge badge-sm bg-light text-dark border">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0">{{ $detail->notes ?: '-' }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-success-soft { background-color: #dcfce7 !important; }
.bg-danger-soft { background-color: #fee2e2 !important; }
.bg-warning-soft { background-color: #fef3c7 !important; }
.bg-dark-soft { background-color: #f3f4f6 !important; }

.icon-sm {
    width: 32px;
    height: 32px;
}
</style>
@endpush