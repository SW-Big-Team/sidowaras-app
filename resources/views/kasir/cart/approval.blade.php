@extends('layouts.kasir.app')

@section('breadcrumb', 'Cart / Approval')
@section('page-title', 'Approval Cart Karyawan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-dark font-weight-bold mb-0">Daftar Cart Menunggu Approval</h6>
                            <p class="text-sm text-muted mb-0">Kelola pengajuan cart dari karyawan</p>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle mb-0" type="button" data-bs-toggle="dropdown">
                                    <i class="material-symbols-rounded text-sm">filter_list</i> Filter
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Semua Status</a></li>
                                    <li><a class="dropdown-item" href="#">Pending</a></li>
                                    <li><a class="dropdown-item" href="#">Approved</a></li>
                                    <li><a class="dropdown-item" href="#">Rejected</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
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
                                <!-- Cart Item 1 - Pending -->
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-bold">CART-001</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0 text-sm">Budi Santoso</h6>
                                            <p class="text-xs text-secondary mb-0">budi.santoso@sidowaras.com</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">12 items</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-primary">Rp 450.000</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">07 Okt 2025</p>
                                        <p class="text-xs text-secondary mb-0">10:30 WIB</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-info mb-0 me-1" data-bs-toggle="modal" data-bs-target="#detailModal1">
                                            <i class="material-symbols-rounded text-sm">visibility</i>
                                        </button>
                                        <button class="btn btn-sm btn-success mb-0 me-1" onclick="approveCart(1)">
                                            <i class="material-symbols-rounded text-sm">check</i>
                                        </button>
                                        <button class="btn btn-sm btn-danger mb-0" onclick="rejectCart(1)">
                                            <i class="material-symbols-rounded text-sm">close</i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cart Item 2 - Pending -->
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-bold">CART-002</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0 text-sm">Siti Aminah</h6>
                                            <p class="text-xs text-secondary mb-0">siti.aminah@sidowaras.com</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">8 items</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-primary">Rp 320.000</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">07 Okt 2025</p>
                                        <p class="text-xs text-secondary mb-0">09:15 WIB</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-info mb-0 me-1" data-bs-toggle="modal" data-bs-target="#detailModal2">
                                            <i class="material-symbols-rounded text-sm">visibility</i>
                                        </button>
                                        <button class="btn btn-sm btn-success mb-0 me-1" onclick="approveCart(2)">
                                            <i class="material-symbols-rounded text-sm">check</i>
                                        </button>
                                        <button class="btn btn-sm btn-danger mb-0" onclick="rejectCart(2)">
                                            <i class="material-symbols-rounded text-sm">close</i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cart Item 3 - Approved -->
                                <tr class="bg-light">
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-bold">CART-003</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0 text-sm">Ahmad Reza</h6>
                                            <p class="text-xs text-secondary mb-0">ahmad.reza@sidowaras.com</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">5 items</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-primary">Rp 180.000</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">06 Okt 2025</p>
                                        <p class="text-xs text-secondary mb-0">16:45 WIB</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-success">Approved</span>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-info mb-0" data-bs-toggle="modal" data-bs-target="#detailModal3">
                                            <i class="material-symbols-rounded text-sm">visibility</i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cart Item 4 - Rejected -->
                                <tr class="bg-light">
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-bold">CART-004</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0 text-sm">Dewi Kusuma</h6>
                                            <p class="text-xs text-secondary mb-0">dewi.kusuma@sidowaras.com</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">15 items</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-primary">Rp 560.000</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">06 Okt 2025</p>
                                        <p class="text-xs text-secondary mb-0">14:20 WIB</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-danger">Rejected</span>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-info mb-0" data-bs-toggle="modal" data-bs-target="#detailModal4">
                                            <i class="material-symbols-rounded text-sm">visibility</i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal 1 -->
<div class="modal fade" id="detailModal1" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Cart CART-001</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-sm mb-1"><strong>Karyawan:</strong> Budi Santoso</p>
                        <p class="text-sm mb-1"><strong>Email:</strong> budi.santoso@sidowaras.com</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-sm mb-1"><strong>Waktu Dibuat:</strong> 07 Okt 2025, 10:30 WIB</p>
                        <p class="text-sm mb-1"><strong>Status:</strong> <span class="badge bg-warning">Pending</span></p>
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
                            <tr>
                                <td>Paracetamol 500mg</td>
                                <td>5 box</td>
                                <td>Rp 15.000</td>
                                <td>Rp 75.000</td>
                            </tr>
                            <tr>
                                <td>Amoxicillin 500mg</td>
                                <td>3 box</td>
                                <td>Rp 25.000</td>
                                <td>Rp 75.000</td>
                            </tr>
                            <tr>
                                <td>Vitamin C 1000mg</td>
                                <td>4 box</td>
                                <td>Rp 45.000</td>
                                <td>Rp 180.000</td>
                            </tr>
                            <tr>
                                <td>OBH Combi</td>
                                <td>2 botol</td>
                                <td>Rp 18.500</td>
                                <td>Rp 37.000</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold">
                                <td colspan="3" class="text-end">Total:</td>
                                <td>Rp 450.000</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-3">
                    <label class="form-label text-sm font-weight-bold">Catatan:</label>
                    <textarea class="form-control" rows="2" placeholder="Tambahkan catatan untuk approval/rejection..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" onclick="rejectCart(1)" data-bs-dismiss="modal">
                    <i class="material-symbols-rounded text-sm me-1">close</i> Reject
                </button>
                <button type="button" class="btn btn-success" onclick="approveCart(1)" data-bs-dismiss="modal">
                    <i class="material-symbols-rounded text-sm me-1">check</i> Approve
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal 2 -->
<div class="modal fade" id="detailModal2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Cart CART-002</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-sm mb-1"><strong>Karyawan:</strong> Siti Aminah</p>
                        <p class="text-sm mb-1"><strong>Email:</strong> siti.aminah@sidowaras.com</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-sm mb-1"><strong>Waktu Dibuat:</strong> 07 Okt 2025, 09:15 WIB</p>
                        <p class="text-sm mb-1"><strong>Status:</strong> <span class="badge bg-warning">Pending</span></p>
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
                            <tr>
                                <td>Betadine Salep</td>
                                <td>6 tube</td>
                                <td>Rp 22.000</td>
                                <td>Rp 132.000</td>
                            </tr>
                            <tr>
                                <td>Promag Tablet</td>
                                <td>8 strip</td>
                                <td>Rp 12.500</td>
                                <td>Rp 100.000</td>
                            </tr>
                            <tr>
                                <td>Paracetamol 500mg</td>
                                <td>3 box</td>
                                <td>Rp 15.000</td>
                                <td>Rp 45.000</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold">
                                <td colspan="3" class="text-end">Total:</td>
                                <td>Rp 320.000</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-3">
                    <label class="form-label text-sm font-weight-bold">Catatan:</label>
                    <textarea class="form-control" rows="2" placeholder="Tambahkan catatan untuk approval/rejection..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" onclick="rejectCart(2)" data-bs-dismiss="modal">
                    <i class="material-symbols-rounded text-sm me-1">close</i> Reject
                </button>
                <button type="button" class="btn btn-success" onclick="approveCart(2)" data-bs-dismiss="modal">
                    <i class="material-symbols-rounded text-sm me-1">check</i> Approve
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function approveCart(cartId) {
        if (confirm('Yakin ingin menyetujui cart ini?')) {
            // AJAX call to approve cart
            alert('Cart CART-00' + cartId + ' telah disetujui!');
            location.reload();
        }
    }

    function rejectCart(cartId) {
        if (confirm('Yakin ingin menolak cart ini?')) {
            // AJAX call to reject cart
            alert('Cart CART-00' + cartId + ' telah ditolak!');
            location.reload();
        }
    }
</script>
@endpush
