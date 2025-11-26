@extends('layouts.admin.app')

@section('title', 'Daftar User')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen User</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Daftar User</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-dark border-0 shadow-lg rounded-3">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                                    <i class="material-symbols-rounded text-dark">group</i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-white fw-bold">Daftar User</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">Kelola data pengguna dan akses sistem</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <div class="d-flex gap-2 justify-content-md-end">
                                <a href="{{ route('admin.shift.index') }}" class="btn btn-outline-white mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1">
                                    <i class="material-symbols-rounded text-sm">schedule</i> Shift
                                </a>
                                <a href="{{ route('admin.users.create') }}" class="btn bg-white text-dark mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1">
                                    <i class="material-symbols-rounded text-sm">add</i> Tambah User
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                Total User
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">{{ $users->count() }}</h4>
                            <p class="mb-0 text-xxs text-muted mt-1">Pengguna terdaftar</p>
                        </div>
                        <div class="summary-icon bg-soft-primary">
                            <i class="material-symbols-rounded text-primary">group</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                User Baru
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">
                                {{ $users->where('created_at', '>=', now()->subDays(7))->count() }}
                            </h4>
                            <p class="mb-0 text-xxs text-muted mt-1">Daftar 7 hari terakhir</p>
                        </div>
                        <div class="summary-icon bg-soft-success">
                            <i class="material-symbols-rounded text-success">person_add</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                User Aktif
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">
                                {{ $users->where('is_active', true)->count() }}
                            </h4>
                            <p class="mb-0 text-xxs text-muted mt-1">Status akun aktif</p>
                        </div>
                        <div class="summary-icon bg-soft-info">
                            <i class="material-symbols-rounded text-info">verified_user</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded align-middle">check_circle</i></span>
            <span class="alert-text fw-bold">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
            <span class="alert-text fw-bold">{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white pb-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="mb-0 fw-bold">Data Pengguna</h6>
                                <span class="text-xs text-secondary">
                                    {{ $users->count() }} user terdaftar
                                </span>
                            </div>
                        </div>
                        {{-- Placeholder filter/search UI --}}
                        <div class="d-flex gap-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-0">
                                    <i class="material-symbols-rounded text-secondary" style="font-size: 18px;">search</i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light text-xs" placeholder="Cari user...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-stok">
                            <thead class="bg-gradient-dark">
                                <tr>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-4">ID</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Nama Lengkap</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Email</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Role</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2 text-center">Status</th>
                                    <th class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-9">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0 text-secondary">{{ $user->id }}</p>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm fw-bold text-dark">{{ $user->nama_lengkap }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 text-secondary">{{ $user->email }}</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-info-soft text-info fw-bold">
                                                {{ $user->role->nama_role ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input 
                                                    class="form-check-input status-switch" 
                                                    type="checkbox" 
                                                    data-user-id="{{ $user->id }}"
                                                    data-user-name="{{ $user->nama_lengkap }}"
                                                    {{ $user->is_active ? 'checked' : '' }}
                                                    {{ $user->id === Auth::id() ? 'disabled' : '' }}
                                                    id="status-switch-{{ $user->id }}"
                                                >
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <x-action-buttons 
                                                editUrl="{{ route('admin.users.edit', $user->id) }}"
                                                deleteUrl="{{ route('admin.users.destroy', $user->id) }}"
                                                deleteConfirm="Yakin ingin menghapus user {{ $user->nama_lengkap }}?"
                                            />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div class="icon icon-lg icon-shape bg-light shadow-sm rounded-circle mb-3">
                                                    <i class="material-symbols-rounded text-secondary opacity-5" style="font-size: 2rem;">person_off</i>
                                                </div>
                                                <h6 class="text-secondary mb-1">Belum ada data user</h6>
                                            </div>
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
document.addEventListener('DOMContentLoaded', function() {
    const statusSwitches = document.querySelectorAll('.status-switch');
    
    statusSwitches.forEach(function(switchElement) {
        switchElement.addEventListener('change', function() {
            const userId = this.getAttribute('data-user-id');
            const userName = this.getAttribute('data-user-name');
            const isChecked = this.checked;
            const switchElement = this;
            
            // Disable switch during request
            switchElement.disabled = true;
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Make AJAX request
            fetch(`/adminx/users/${userId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Gagal mengubah status user');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    // Revert switch state on error
                    switchElement.checked = !isChecked;
                    alert(data.message || 'Gagal mengubah status user');
                }
            })
            .catch(error => {
                // Revert switch state on error
                switchElement.checked = !isChecked;
                console.error('Error:', error);
                alert(error.message || 'Terjadi kesalahan saat mengubah status user');
            })
            .finally(() => {
                // Re-enable switch
                switchElement.disabled = false;
            });
        });
    });
});
</script>
@endpush

<style>
    .text-xxs { font-size: 0.65rem !important; }
    .shadow-sm-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }

    .bg-gradient-info-soft {
        background: linear-gradient(135deg, rgba(23, 162, 184, .08), rgba(23, 162, 184, .16));
        color: #138496;
    }

    .bg-soft-primary { background: rgba(94, 114, 228, 0.10) !important; }
    .bg-soft-success { background: rgba(40, 167, 69, 0.08) !important; }
    .bg-soft-warning { background: rgba(255, 193, 7, 0.12) !important; }
    .bg-soft-info { background: rgba(23, 162, 184, 0.12) !important; }
    .bg-soft-secondary { background: rgba(108, 117, 125, 0.12) !important; }

    /* Summary Card Styles */
    .summary-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }
    .summary-icon {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
    }

    .table-stok thead tr th {
        border-top: none;
        font-weight: 600;
        letter-spacing: .04em;
    }

    .table-stok tbody tr {
        transition: background-color 0.15s ease, box-shadow 0.15s ease;
    }
    .table-stok tbody tr:hover {
        background-color: #f8f9fe;
    }

    .table td, .table th { vertical-align: middle; }
</style>
@endsection
