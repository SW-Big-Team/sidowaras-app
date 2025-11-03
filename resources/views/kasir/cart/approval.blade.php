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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Cart</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Karyawan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Item</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu Dibuat</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-secondary opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form id="approvalForm" method="POST" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="cart_id" id="cartIdForApproval">
                                </form>
                                @forelse($carts as $cart)
                                    <tr>
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
                                                <button type="button" class="btn btn-sm btn-success mb-0 me-1"
                                                        onclick="showApprovalModal({{ $cart->id }}, {{ $cart->items->sum(fn($i) => $i->jumlah * $i->harga_satuan) }}, '{{ ucfirst($cart->metode_pembayaran) }}')">
                                                    <i class="material-symbols-rounded text-sm">check</i>
                                                </button>
                                            </form>
                                            <form action="{{ route('kasir.cart.reject', $cart) }}" method="POST" style="display:inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger mb-0" onclick="return confirm('Tolak cart ini?')">
                                                    <i class="material-symbols-rounded text-sm">close</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

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
                                                        <!-- Modal Konfirmasi Pembayaran -->
                                                        <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="approvalModalLabel">Konfirmasi Pembayaran</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p><strong>Total Harga:</strong> <span id="modalTotal"></span></p>
                                                                        <p><strong>Metode Pembayaran:</strong> <span id="modalMetode"></span></p>
                                                                        <div class="mt-3">
                                                                            <label class="form-label">Total Bayar (Opsional)</label>
                                                                            <input type="number" id="totalBayar" class="form-control" placeholder="0" min="0">
                                                                            <small class="text-muted">Biarkan kosong jika tidak perlu hitung kembalian</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="button" class="btn btn-success" onclick="confirmApproval()">Approve & Simpan Transaksi</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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

@push('scripts')
<script>
    let currentCartId = null;
    let currentTotalHarga = 0;

    function showApprovalModal(cartId, totalHarga, metode) {
        currentCartId = cartId;
        currentTotalHarga = totalHarga;

        document.getElementById('modalTotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalHarga);
        document.getElementById('modalMetode').textContent = metode;
        document.getElementById('totalBayar').value = '';
        
        const modal = new bootstrap.Modal(document.getElementById('approvalModal'));
        modal.show();
    }

    function confirmApproval() {
        if (!currentCartId) return;

        const totalBayarInput = document.getElementById('totalBayar').value;
        const totalBayar = totalBayarInput ? parseFloat(totalBayarInput) : 0;

        if (totalBayar > 0 && totalBayar < currentTotalHarga) {
            alert('Total bayar tidak boleh kurang dari total harga!');
            return;
        }

        // Submit form approval
        const form = document.getElementById('approvalForm');
        form.action = `/kasir/cart/${currentCartId}/approve`;
        form.querySelector('input[name="cart_id"]').value = currentCartId;
        form.submit();
    }
</script>
@endpush

@endsection