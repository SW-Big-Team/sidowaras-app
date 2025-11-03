@extends('layouts.admin.app')

@section('title', 'Daftar User')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-icon"><i class="material-symbols-rounded">check_circle</i></span>
                    <span class="alert-text">{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-icon"><i class="material-symbols-rounded">error</i></span>
                    <span class="alert-text">{{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-dark font-weight-bold mb-0">Daftar User</h6>
                            <p class="text-sm text-muted mb-0">Kelola data pengguna sistem</p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-0">
                                <i class="material-symbols-rounded text-sm me-1">add</i> Tambah User
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Lengkap</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-secondary opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm font-weight-bold">{{ $user->id }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm">{{ $user->nama_lengkap }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $user->role->nama_role ?? '-' }}</p>
                                        </td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="badge badge-sm bg-gradient-success">Aktif</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-info mb-0 me-1" title="Edit">
                                                <i class="material-symbols-rounded text-sm">edit</i>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger mb-0" onclick="return confirm('Yakin ingin menghapus user ini?')" title="Hapus">
                                                    <i class="material-symbols-rounded text-sm">delete</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
