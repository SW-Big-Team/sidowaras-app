@extends('layouts.kasir.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h4 class="text-dark font-weight-bold mb-1">Approval Cart Karyawan</h4>
        <p class="text-sm text-muted mb-4">Kelola pengajuan cart dari karyawan</p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-dark font-weight-bold mb-0">Daftar Cart Menunggu Approval</h6>
                        <p class="text-xs text-muted mb-0 mt-1">{{ $carts->count() }} cart menunggu persetujuan</p>
                    </div>
                    @if($carts->count() > 0)
                        <span class="badge bg-warning px-3 py-2">{{ $carts->count() }} Pending</span>
                    @endif
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                        <i class="material-symbols-rounded align-middle me-2">check_circle</i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
                        <i class="material-symbols-rounded align-middle me-2">error</i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Cart</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Karyawan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Item</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Harga</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($carts as $cart)
                                @php
                                    $totalItems = $cart->items->sum('jumlah');
                                    $totalPrice = $cart->items->sum(fn($i) => $i->jumlah * $i->harga_satuan);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="icon icon-shape icon-sm bg-success text-white rounded-circle me-3">
                                                <i class="material-symbols-rounded opacity-10" style="font-size: 1rem;">shopping_cart</i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">CART-{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $cart->uuid }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $cart->user->nama ?? $cart->user->nama_lengkap ?? 'Unknown' }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $cart->user->email ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $totalItems }}</p>
                                        <p class="text-xs text-secondary mb-0">item{{ $totalItems > 1 ? 's' : '' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $cart->created_at->format('d M Y') }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $cart->created_at->format('H:i') }} WIB</p>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('kasir.cart.showPayment', $cart) }}" class="btn btn-sm btn-success mb-0 me-1">
                                            <i class="material-symbols-rounded text-sm align-middle">check</i>
                                            <span class="d-none d-sm-inline">Approve</span>
                                        </a>
                                        <form action="{{ route('kasir.cart.reject', $cart) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger mb-0" onclick="return confirm('Yakin ingin menolak cart ini?')">
                                                <i class="material-symbols-rounded text-sm align-middle">close</i>
                                                <span class="d-none d-sm-inline">Reject</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="material-symbols-rounded text-success" style="font-size: 4rem;">check_circle</i>
                                        <h6 class="text-muted mt-3 mb-1">Tidak Ada Cart Menunggu</h6>
                                        <p class="text-xs text-secondary mb-0">Semua cart telah diproses</p>
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
@endsection