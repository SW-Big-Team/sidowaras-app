@extends('layouts.kasir.app')

@section('breadcrumb', 'Cart / Approval')
@section('page-title', 'Approval Cart Karyawan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="text-dark font-weight-bold mb-0">Daftar Cart Menunggu Approval</h6>
                    <p class="text-sm text-muted mb-0">Kelola pengajuan cart dari karyawan</p>
                </div>
                <div class="card-body px-0 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>ID Cart</th>
                                    <th>Karyawan</th>
                                    <th>Total Item</th>
                                    <th>Total Harga</th>
                                    <th>Waktu Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($carts as $cart)
                                    <tr>
                                        <td>CART-{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $cart->user->nama_lengkap }}</td>
                                        <td>{{ $cart->items->sum('jumlah') }} item</td>
                                        <td>Rp {{ number_format($cart->items->sum(fn($i) => $i->jumlah * $i->harga_satuan), 0, ',', '.') }}</td>
                                        <td>{{ $cart->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('kasir.cart.showPayment', $cart) }}" class="btn btn-sm btn-success mb-0 me-1">
                                                <i class="material-symbols-rounded text-sm">check</i> Approve
                                            </a>
                                            <form action="{{ route('kasir.cart.reject', $cart) }}" method="POST" style="display:inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger mb-0" onclick="return confirm('Tolak cart ini?')">
                                                    <i class="material-symbols-rounded text-sm">close</i> Reject
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="material-symbols-rounded text-muted" style="font-size: 2.5rem;">shopping_cart</i>
                                            <p class="text-muted mt-2">Tidak ada cart menunggu approval</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection