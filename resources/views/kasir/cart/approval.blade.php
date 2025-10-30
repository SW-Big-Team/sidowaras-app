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
<<<<<<< HEAD
<<<<<<< HEAD
                    <h6 class="text-dark font-weight-bold mb-0">Daftar Cart Menunggu Approval</h6>
                    <p class="text-sm text-muted mb-0">Kelola pengajuan cart dari karyawan</p>
=======
>>>>>>> 3c117fd (Add Cart functionality and update Bootstrap version)
=======
                    <h6 class="text-dark font-weight-bold mb-0">Daftar Cart Menunggu Approval</h6>
                    <p class="text-sm text-muted mb-0">Kelola pengajuan cart dari karyawan</p>
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
                </div>
                <div class="card-body px-0 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

<<<<<<< HEAD
=======
>>>>>>> 3c117fd (Add Cart functionality and update Bootstrap version)
=======
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
<<<<<<< HEAD
                                        <td>CART-{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $cart->user->nama_lengkap }}</td>
                                        <td>{{ $cart->items->sum('jumlah') }} item</td>
                                        <td>Rp {{ number_format($cart->items->sum(fn($i) => $i->jumlah * $i->harga_satuan), 0, ',', '.') }}</td>
                                        <td>{{ $cart->created_at->format('d M Y H:i') }}</td>
<<<<<<< HEAD
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
=======
=======
>>>>>>> f5d5d3d (Add Cart functionality and update Bootstrap version)
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <h6 class="mb-0 text-sm font-weight-bold">CART-{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm">{{ $cart->user->nama_lengkap }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $cart->items->sum('jumlah') }} item</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0 text-primary">
                                                Rp {{ number_format($cart->items->sum(fn($i) => $i->jumlah * $i->harga_satuan), 0, ',', '.') }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">{{ $cart->created_at->format('d M Y') }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $cart->created_at->format('H:i') }} WIB</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                        </td>
                                        <td class="align-middle">
                                            <button class="btn btn-sm btn-info mb-0 me-1" data-bs-toggle="modal" data-bs-target="#detailModal{{ $cart->id }}">
                                                <i class="material-symbols-rounded text-sm">visibility</i>
                                            </button>
                                            <form action="{{ route('kasir.cart.approve', $cart) }}" method="POST" style="display:inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success mb-0 me-1" onclick="return confirm('Setujui cart ini?')">
                                                    <i class="material-symbols-rounded text-sm">check</i>
                                                </button>
                                            </form>
                                            <form action="{{ route('kasir.cart.reject', $cart) }}" method="POST" style="display:inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger mb-0" onclick="return confirm('Tolak cart ini?')">
<<<<<<< HEAD
<<<<<<< HEAD
                                                    <i class="material-symbols-rounded text-sm">close</i>
=======
=======
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
                                                    <i class="material-symbols-rounded text-sm">close</i> Reject
=======
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <h6 class="mb-0 text-sm font-weight-bold">CART-{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm">{{ $cart->user->nama_lengkap }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $cart->items->sum('jumlah') }} item</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0 text-primary">
                                                Rp {{ number_format($cart->items->sum(fn($i) => $i->jumlah * $i->harga_satuan), 0, ',', '.') }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">{{ $cart->created_at->format('d M Y') }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $cart->created_at->format('H:i') }} WIB</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                        </td>
                                        <td class="align-middle">
                                            <button class="btn btn-sm btn-info mb-0 me-1" data-bs-toggle="modal" data-bs-target="#detailModal{{ $cart->id }}">
                                                <i class="material-symbols-rounded text-sm">visibility</i>
                                            </button>
                                            <form action="{{ route('kasir.cart.approve', $cart) }}" method="POST" style="display:inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success mb-0 me-1" onclick="return confirm('Setujui cart ini?')">
                                                    <i class="material-symbols-rounded text-sm">check</i>
                                                </button>
                                            </form>
                                            <form action="{{ route('kasir.cart.reject', $cart) }}" method="POST" style="display:inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger mb-0" onclick="return confirm('Tolak cart ini?')">
                                                    <i class="material-symbols-rounded text-sm">close</i>
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
<<<<<<< HEAD
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
=======
=======
                                                    <i class="material-symbols-rounded text-sm">close</i>
>>>>>>> f5d5d3d (Add Cart functionality and update Bootstrap version)
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
<<<<<<< HEAD
<<<<<<< HEAD

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="detailModal{{ $cart->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Cart CART-{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <p class="text-sm mb-1"><strong>Karyawan:</strong> {{ $cart->user->nama_lengkap }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="text-sm mb-1"><strong>Waktu Dibuat:</strong> {{ $cart->created_at->format('d M Y, H:i') }} WIB</p>
                                                        </div>
                                                    </div>

                                                    <h6 class="text-sm font-weight-bold mb-2">Detail Item:</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nama Obat</th>
                                                                    <th>Jumlah</th>
                                                                    <th>Harga Satuan</th>
                                                                    <th>Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($cart->items as $item)
                                                                    <tr>
                                                                        <td>{{ $item->obat->nama_obat }}</td>
                                                                        <td>{{ $item->jumlah }}</td>
                                                                        <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                                                        <td>Rp {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr class="font-weight-bold">
                                                                    <td colspan="3" class="text-end">Total:</td>
                                                                    <td>Rp {{ number_format($cart->items->sum(fn($i) => $i->jumlah * $i->harga_satuan), 0, ',', '.') }}</td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <form action="{{ route('kasir.cart.reject', $cart) }}" method="POST" style="display:inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak cart ini?')">
                                                            <i class="material-symbols-rounded text-sm me-1">close</i> Reject
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('kasir.cart.approve', $cart) }}" method="POST" style="display:inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success" onclick="return confirm('Setujui cart ini?')">
                                                            <i class="material-symbols-rounded text-sm me-1">check</i> Approve
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
=======
=======
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
<<<<<<< HEAD
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
=======

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="detailModal{{ $cart->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Cart CART-{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <p class="text-sm mb-1"><strong>Karyawan:</strong> {{ $cart->user->nama_lengkap }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="text-sm mb-1"><strong>Waktu Dibuat:</strong> {{ $cart->created_at->format('d M Y, H:i') }} WIB</p>
                                                        </div>
                                                    </div>

                                                    <h6 class="text-sm font-weight-bold mb-2">Detail Item:</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nama Obat</th>
                                                                    <th>Jumlah</th>
                                                                    <th>Harga Satuan</th>
                                                                    <th>Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($cart->items as $item)
                                                                    <tr>
                                                                        <td>{{ $item->obat->nama_obat }}</td>
                                                                        <td>{{ $item->jumlah }}</td>
                                                                        <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                                                        <td>Rp {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr class="font-weight-bold">
                                                                    <td colspan="3" class="text-end">Total:</td>
                                                                    <td>Rp {{ number_format($cart->items->sum(fn($i) => $i->jumlah * $i->harga_satuan), 0, ',', '.') }}</td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <form action="{{ route('kasir.cart.reject', $cart) }}" method="POST" style="display:inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak cart ini?')">
                                                            <i class="material-symbols-rounded text-sm me-1">close</i> Reject
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('kasir.cart.approve', $cart) }}" method="POST" style="display:inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success" onclick="return confirm('Setujui cart ini?')">
                                                            <i class="material-symbols-rounded text-sm me-1">check</i> Approve
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
<<<<<<< HEAD
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
=======
=======

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="detailModal{{ $cart->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Cart CART-{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <p class="text-sm mb-1"><strong>Karyawan:</strong> {{ $cart->user->nama_lengkap }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="text-sm mb-1"><strong>Waktu Dibuat:</strong> {{ $cart->created_at->format('d M Y, H:i') }} WIB</p>
                                                        </div>
                                                    </div>

                                                    <h6 class="text-sm font-weight-bold mb-2">Detail Item:</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nama Obat</th>
                                                                    <th>Jumlah</th>
                                                                    <th>Harga Satuan</th>
                                                                    <th>Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($cart->items as $item)
                                                                    <tr>
                                                                        <td>{{ $item->obat->nama_obat }}</td>
                                                                        <td>{{ $item->jumlah }}</td>
                                                                        <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                                                        <td>Rp {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr class="font-weight-bold">
                                                                    <td colspan="3" class="text-end">Total:</td>
                                                                    <td>Rp {{ number_format($cart->items->sum(fn($i) => $i->jumlah * $i->harga_satuan), 0, ',', '.') }}</td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <form action="{{ route('kasir.cart.reject', $cart) }}" method="POST" style="display:inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak cart ini?')">
                                                            <i class="material-symbols-rounded text-sm me-1">close</i> Reject
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('kasir.cart.approve', $cart) }}" method="POST" style="display:inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success" onclick="return confirm('Setujui cart ini?')">
                                                            <i class="material-symbols-rounded text-sm me-1">check</i> Approve
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
>>>>>>> f5d5d3d (Add Cart functionality and update Bootstrap version)
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
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