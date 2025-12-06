@php
    $role = Auth::user()->role->nama_role;
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title','Daftar Pembelian')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Transaksi</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Daftar Pembelian</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-dark border-0 shadow-lg rounded-3">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                                    <i class="material-symbols-rounded text-dark">receipt_long</i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-white fw-bold">Daftar Pembelian</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">
                                        Kelola riwayat pembelian dan stok masuk obat.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <a href="{{ route('pembelian.create') }}" class="btn bg-white mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1">
                                <i class="material-symbols-rounded align-middle">add_circle</i>
                                <span>Tambah Pembelian</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded align-middle">check_circle</i></span>
            <span class="alert-text"><strong>Sukses!</strong> {{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
   
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
            <span class="alert-text"><strong>Error!</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white pb-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="mb-0 fw-bold">Data Pembelian</h6>
                                <span class="badge bg-soft-primary text-primary text-xs fw-bold rounded-pill">
                                    {{ $pembelian->total() }} data
                                </span>
                            </div>
                        </div>
                        {{-- Search UI --}}
                        <div class="d-flex align-items-center gap-2">
                            <form action="{{ route('pembelian.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-nowrap">
                                {{-- Search Input with Icon --}}
                                <div class="input-group" style="width: 220px;">
                                    <span class="input-group-text bg-white" style="border-radius: 8px 0 0 8px; border-right: 0;">
                                        <i class="material-symbols-rounded text-secondary" style="font-size: 18px;">search</i>
                                    </span>
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}" 
                                           class="form-control ps-0" 
                                           style="border-radius: 0 8px 8px 0; border-left: 0;"
                                           placeholder="Cari pembelian...">
                                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                </div>
                                {{-- Search Button --}}
                                <button type="submit" class="btn bg-gradient-dark mb-0 px-3" style="border-radius: 8px;">
                                    <i class="material-symbols-rounded" style="font-size: 18px;">search</i>
                                </button>
                                {{-- Clear Filter --}}
                                @if(request('search'))
                                    <a href="{{ route('pembelian.index') }}" class="btn btn-outline-secondary mb-0 px-3" style="border-radius: 8px;" title="Hapus Filter">
                                        <i class="material-symbols-rounded" style="font-size: 18px;">close</i>
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-stok">
                            <thead class="bg-gradient-dark">
                                <tr>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-4">#</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">No Faktur</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Pengirim</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2 text-end pe-4">Total Harga</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Metode</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">User</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Tanggal</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pembelian as $p)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0 text-secondary">
                                                {{ $loop->iteration + ($pembelian->firstItem() - 1) }}
                                            </p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-info-soft text-info fw-semibold">
                                                {{ $p->no_faktur }}
                                            </span>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0 fw-semibold">{{ $p->nama_pengirim }}</p>
                                        </td>
                                        <td class="text-end pe-4">
                                            <span class="text-sm fw-bold text-dark">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($p->metode_pembayaran == 'tunai')
                                                <span class="badge badge-sm bg-soft-success text-success">Tunai</span>
                                            @elseif($p->metode_pembayaran == 'non tunai')
                                                <span class="badge badge-sm bg-soft-primary text-primary">Non Tunai</span>
                                            @else
                                                <span class="badge badge-sm bg-soft-warning text-warning">Termin</span>
                                            @endif
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">{{ $p->user->nama_lengkap ?? $p->user->name ?? '-' }}</p>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $p->tgl_pembelian->format('d/m/Y H:i') }}</span>
                                        </td>
                                        <td class="text-center">
                                            {{-- PERBAIKAN: Gunakan UUID --}}
                                            <form action="{{ route('pembelian.destroy', $p->uuid) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                                
                                                @if($p->metode_pembayaran == 'termin')
                                                    @php
                                                        $belum_lunas = $p->pembayaranTermin->where('status', 'belum_lunas')->isNotEmpty();
                                                    @endphp
                                                    @if($belum_lunas)
                                                        {{-- Tombol bayar mengarah ke SHOW/Detail --}}
                                                        <a href="{{ route('pembelian.show', $p->uuid) }}" class="btn btn-link text-success text-gradient px-1 mb-0" title="Bayar Termin">
                                                            <i class="material-symbols-rounded text-sm me-2">payments</i>
                                                        </a>
                                                    @endif
                                                @endif

                                                <a href="{{ route('pembelian.show', $p->uuid) }}" class="btn btn-link text-info text-gradient px-1 mb-0" title="Detail">
                                                    <i class="material-symbols-rounded text-sm me-2">visibility</i>
                                                </a>
                                                <a href="{{ route('pembelian.edit', $p->uuid) }}" class="btn btn-link text-warning text-gradient px-1 mb-0" title="Edit">
                                                    <i class="material-symbols-rounded text-sm me-2">edit</i>
                                                </a>
                                                
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-link text-danger text-gradient px-1 mb-0" title="Hapus">
                                                    <i class="material-symbols-rounded text-sm me-2">delete</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div class="icon icon-lg icon-shape bg-light shadow-sm rounded-circle mb-3">
                                                    <i class="material-symbols-rounded text-secondary opacity-5" style="font-size: 2rem;">receipt_long</i>
                                                </div>
                                                <h6 class="text-secondary mb-1">Belum ada data pembelian</h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white border-top py-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            {{-- Left: Per Page Selector --}}
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-xs text-secondary">Tampilkan</span>
                                <select class="form-select form-select-sm border rounded-2 px-2 py-1" 
                                        style="width: auto; min-width: 65px;" 
                                        onchange="window.location.href='{{ route('pembelian.index') }}?per_page='+this.value">
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <span class="text-xs text-secondary">data per halaman</span>
                            </div>
                            {{-- Center: Info --}}
                            <p class="text-xs text-secondary mb-0">
                                <span class="fw-bold">{{ $pembelian->firstItem() ?? 0 }}</span> - 
                                <span class="fw-bold">{{ $pembelian->lastItem() ?? 0 }}</span> dari 
                                <span class="fw-bold">{{ $pembelian->total() }}</span> data
                            </p>
                            {{-- Right: Pagination --}}
                            <div>
                                {{ $pembelian->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-xxs { font-size: 0.65rem !important; }
    .shadow-sm-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }
    .bg-soft-success { background: rgba(40, 167, 69, 0.08) !important; }
    .bg-soft-warning { background: rgba(255, 193, 7, 0.12) !important; }
    .bg-soft-danger  { background: rgba(220, 53, 69, 0.10) !important; }
    .bg-soft-primary { background: rgba(94, 114, 228, 0.10) !important; }
    .bg-soft-secondary { background: rgba(108, 117, 125, 0.08) !important; }
    .bg-gradient-info-soft { background: linear-gradient(135deg, rgba(23, 162, 184, .08), rgba(23, 162, 184, .16)); }
    .table-stok thead tr th { border-top: none; font-weight: 600; letter-spacing: .04em; }
    .table-stok tbody tr { transition: background-color 0.15s ease, box-shadow 0.15s ease; }
    .table-stok tbody tr:hover { background-color: #f8f9fe; }
    .badge.bg-gradient-info-soft { background: linear-gradient(135deg, rgba(23, 162, 184, .08), rgba(23, 162, 184, .16)); color: #138496; }
    .table td, .table th { vertical-align: middle; }
</style>
@endsection