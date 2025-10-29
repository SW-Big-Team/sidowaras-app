@extends('layouts.admin.app')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-dark font-weight-bold mb-0">Edit User</h6>
                            <p class="text-sm text-muted mb-0">Perbarui informasi pengguna</p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary mb-0">
                                <i class="material-symbols-rounded text-sm me-1">arrow_back</i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-sm font-weight-bold">Nama Lengkap</label>
                                    <div class="input-group input-group-outline @error('nama_lengkap') is-invalid @enderror">
                                        <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" placeholder="Masukkan nama lengkap">
                                    </div>
                                    @error('nama_lengkap')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-sm font-weight-bold">Email</label>
                                    <div class="input-group input-group-outline @error('email') is-invalid @enderror">
                                        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" placeholder="Masukkan email">
                                    </div>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-sm font-weight-bold">Password</label>
                                    <small class="text-muted">(kosongkan jika tidak diubah)</small>
                                    <div class="input-group input-group-outline @error('password') is-invalid @enderror">
                                        <input type="password" class="form-control" name="password" placeholder="Masukkan password baru">
                                    </div>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-sm font-weight-bold">Konfirmasi Password</label>
                                    <div class="input-group input-group-outline">
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi password baru">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-sm font-weight-bold">Role</label>
                                    <select class="form-select @error('role_id') is-invalid @enderror" name="role_id">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                {{ $role->nama_role }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-sm font-weight-bold">Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }} id="isActiveSwitch">
                                        <label class="form-check-label" for="isActiveSwitch">Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="material-symbols-rounded text-sm me-1">save</i> Update User
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                    <i class="material-symbols-rounded text-sm me-1">cancel</i> Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
