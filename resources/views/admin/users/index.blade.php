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
        <a href="{{ route('admin.users.create') }}" class="btn bg-gradient-primary mb-0">
            <i class="material-symbols-rounded text-sm me-1">add</i> Tambah User
        </a>
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
                                    @if($user->is_active)
                                        <span class="badge badge-sm bg-gradient-success">
                                            <i class="material-symbols-rounded text-xs me-1">check_circle</i>Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-secondary">
                                            <i class="material-symbols-rounded text-xs me-1">cancel</i>Tidak Aktif
                                        </span>
                                    @endif
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
@endsection
