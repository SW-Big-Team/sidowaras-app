@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title','Daftar Pembelian')

@section('content')
<div class="container-fluid mt-4 px-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="fas fa-list-alt"></i> Daftar Pembelian</h4>
        <a href="{{ route('pembelian.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Pembelian
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover small">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>#</th>
                            <th>No Faktur</th>
                            <th>Pengirim</th>
                            <th>Total Harga</th>
                            <th>Metode Bayar</th>
                            <th>User</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembelian as $p)
                            <tr>
                                <td class="text-center">{{ $loop->iteration + ($pembelian->firstItem() - 1) }}</td>
                                <td>{{ $p->no_faktur }}</td>
                                <td>{{ $p->nama_pengirim }}</td>
                                <td class="text-end">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                
                                <td class="text-center">
                                    @if($p->metode_pembayaran == 'tunai')
                                        <span class="badge bg-success">{{ ucfirst($p->metode_pembayaran) }}</span>
                                    @elseif($p->metode_pembayaran == 'non tunai')
                                        <span class="badge bg-primary">{{ ucfirst($p->metode_pembayaran) }}</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ ucfirst($p->metode_pembayaran) }}</span>
                                    @endif
                                </td>
                                
                                <td>{{ $p->user->nama_lengkap ?? $p->user->name ?? '-' }}</td>
                                <td class="text-center">{{ $p->tgl_pembelian->format('Y-m-d H:i') }}</td>
                                <td class="text-center">
                                    {{-- PERBAIKAN: Gunakan $p->uuid --}}
                                    <form action="{{ route('pembelian.destroy', $p->uuid) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                        
                                        @if($p->metode_pembayaran == 'termin')
                                            @php
                                                $belum_lunas = $p->pembayaranTermin->where('status', 'belum_lunas')->isNotEmpty();
                                            @endphp
                                            @if($belum_lunas)
                                                {{-- PERBAIKAN: Arahkan ke halaman show (detail) --}}
                                                <a href="{{ route('pembelian.show', $p->uuid) }}" class="btn btn-sm btn-success" title="Bayar Termin">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </a>
                                            @endif
                                        @endif

                                        {{-- PERBAIKAN: Gunakan $p->uuid --}}
                                        <a href="{{ route('pembelian.show', $p->uuid) }}" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('pembelian.edit', $p->uuid) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                        
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">Tidak ada data pembelian.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pembelian->links() }}
            </div>
        </div>
    </div>
</div>
@endsection