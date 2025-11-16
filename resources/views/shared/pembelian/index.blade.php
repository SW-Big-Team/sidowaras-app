@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title','Daftar Pembelian')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Stok</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Pembelian Obat</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    <x-content-header title="Daftar Pembelian Obat" subtitle="Kelola transaksi pembelian obat dari supplier">
        <x-button-add
            :href="route('pembelian.create')"
            icon="add_shopping_cart"
            text="Tambah Pembelian"
        />
    </x-content-header>

<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="material-symbols-rounded">check_circle</i></span>
                <span class="alert-text">{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="material-symbols-rounded">error</i></span>
                <span class="alert-text">{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="material-symbols-rounded">error</i></span>
                <span class="alert-text">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-3">
                <div class="mb-3">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group input-group-outline">
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Cari no faktur, pengirim..." 
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-0">
                                <i class="material-symbols-rounded me-1">search</i> Cari
                            </button>
                            @if(request('search'))
                                <a href="{{ route('pembelian.index') }}" class="btn btn-outline-secondary mb-0">
                                    <i class="material-symbols-rounded">close</i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>No Faktur</th>
                                <th>Pengirim</th>
                                <th class="text-end">Total Harga</th>
                                <th class="text-center">Metode Bayar</th>
                                <th>User</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembelian as $p)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration + ($pembelian->firstItem() - 1) }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $p->no_faktur }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $p->nama_pengirim }}</h6>
                                                @if($p->no_telepon_pengirim)
                                                    <p class="text-xs text-secondary mb-0">{{ $p->no_telepon_pengirim }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <p class="text-xs font-weight-bold text-success mb-0">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="text-center">
                                        @if($p->metode_pembayaran == 'tunai')
                                            <span class="badge badge-sm bg-gradient-success">Tunai</span>
                                        @elseif($p->metode_pembayaran == 'non tunai')
                                            <span class="badge badge-sm bg-gradient-info">Non Tunai</span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-warning">Termin</span>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">{{ $p->user->nama_lengkap ?? $p->user->name ?? '-' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs text-secondary mb-0">{{ $p->tgl_pembelian->format('d M Y') }}</p>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            @if($p->metode_pembayaran == 'termin')
                                                @php
                                                    $belum_lunas = $p->pembayaranTermin->where('status', 'belum_lunas')->isNotEmpty();
                                                @endphp
                                                @if($belum_lunas)
                                                    <a href="{{ route('pembelian.show', $p->uuid) }}"
                                                       class="btn btn-link text-success px-3 mb-0"
                                                       title="Bayar Termin">
                                                        <i class="material-symbols-rounded text-sm">payments</i>
                                                    </a>
                                                @endif
                                            @endif

                                            <a href="{{ route('pembelian.show', $p->uuid) }}"
                                               class="btn btn-link text-info px-3 mb-0"
                                               title="Detail">
                                                <i class="material-symbols-rounded text-sm">visibility</i>
                                            </a>
                                            <a href="{{ route('pembelian.edit', $p->uuid) }}"
                                               class="btn btn-link text-warning px-3 mb-0"
                                               title="Edit">
                                                <i class="material-symbols-rounded text-sm">edit</i>
                                            </a>

                                            <form action="{{ route('pembelian.destroy', $p->uuid) }}"
                                                  method="POST"
                                                  class="d-inline m-0"
                                                  onsubmit="return confirm('Yakin ingin menghapus pembelian ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-link text-danger px-3 mb-0"
                                                        title="Hapus">
                                                    <i class="material-symbols-rounded text-sm">delete</i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="material-symbols-rounded text-secondary" style="font-size: 3rem;">shopping_cart</i>
                                        <p class="text-secondary mb-0">Belum ada data pembelian</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($pembelian->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $pembelian->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection