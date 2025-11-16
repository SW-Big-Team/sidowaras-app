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
    <x-content-header title="Daftar User" subtitle="Kelola data pengguna dan akses sistem">
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.shift.index') }}" class="btn bg-gradient-secondary mb-0">
                <i class="material-symbols-rounded text-sm me-1">schedule</i> Shift
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn bg-gradient-primary mb-0">
                <i class="material-symbols-rounded text-sm me-1">add</i> Tambah User
            </a>
        </div>
    </x-content-header>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded">check_circle</i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded">error</i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body px-0 pb-2">
                    <x-data-table>
                        <x-slot name="header">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Lengkap</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </x-slot>

                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $user->id }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0 text-sm">{{ $user->nama_lengkap }}</h6>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm mb-0">{{ $user->email }}</p>
                                </td>
                                <td>
                                    <span class="badge badge-sm bg-gradient-info">
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
                                        <label class="form-check-label" for="status-switch-{{ $user->id }}">
                                            <span class="text-sm">
                                                {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </label>
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
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="material-symbols-rounded text-muted mb-2" style="font-size: 3rem;">person_off</i>
                                        <p class="text-sm text-muted mb-0">Belum ada data user</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </x-data-table>
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
            const label = this.nextElementSibling.querySelector('span');
            
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
                if (data.success) {
                    // Update label text
                    label.textContent = data.is_active ? 'Aktif' : 'Tidak Aktif';
                } else {
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
@endsection
