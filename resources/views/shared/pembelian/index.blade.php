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
    <x-content-header title="Daftar Pembelian Obat" subtitle="Kelola transaksi pembelian dan penerimaan obat">
        <x-button-add 
            :href="route('pembelian.create')" 
            icon="shopping_cart" 
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

            <x-data-table :headers="['#', 'No Faktur', 'Pengirim', 'Total Harga', 'User', 'Tanggal', 'Aksi']">
                @forelse($pembelian as $p)
                    <tr>
                        <td class="ps-4">
                            <p class="text-xs font-weight-bold mb-0">{{ $pembelian->firstItem() + $loop->index }}</p>
                        </td>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">{{ $p->no_faktur }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $p->nama_pengirim }}</p>
                        </td>
                        <td>
                            <span class="badge badge-sm bg-gradient-warning">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <p class="text-xs text-secondary mb-0">{{ $p->user->nama_lengkap ?? '-' }}</p>
                        </td>
                        <td>
                            <p class="text-xs text-secondary mb-0">{{ $p->tgl_pembelian->format('d M Y H:i') }}</p>
                        </td>
                        <td>
                            <x-action-buttons 
                                :viewUrl="route('pembelian.show', $p->uuid)"
                                :editUrl="route('pembelian.edit', $p->uuid)"
                                :deleteUrl="route('pembelian.destroy', $p->uuid)"
                                deleteMessage="Yakin ingin menghapus pembelian {{ $p->no_faktur }}?"
                            />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="material-symbols-rounded text-secondary" style="font-size: 3rem;">shopping_cart</i>
                            <p class="text-secondary mb-0">Belum ada data pembelian obat</p>
                        </td>
                    </tr>
                @endforelse
            </x-data-table>

            <div class="mt-3">
                {{ $pembelian->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
