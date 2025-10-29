@extends('layouts.admin.app')

@section('title', 'Tambah User')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-dark font-weight-bold mb-0">Tambah User Baru</h6>
                            <p class="text-sm text-muted mb-0">Buat pengguna baru untuk sistem</p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary mb-0">
                                <i class="material-symbols-rounded text-sm me-1">arrow_back</i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-sm font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline @error('nama_lengkap') is-invalid @enderror">
                                        <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" required>
                                    </div>
                                    @error('nama_lengkap')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-sm font-weight-bold">Email <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline @error('email') is-invalid @enderror">
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required>
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
                                    <label class="form-label text-sm font-weight-bold">Password <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline @error('password') is-invalid @enderror">
                                        <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
                                    </div>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-sm font-weight-bold">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi password" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-sm font-weight-bold">Role <span class="text-danger">*</span></label>
                                    <select class="form-select @error('role_id') is-invalid @enderror" name="role_id" required>
                                        <option value="">-- Pilih Role --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->nama_role }}</option>
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
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="isActiveSwitch">
                                        <label class="form-check-label" for="isActiveSwitch">Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="material-symbols-rounded text-sm me-1">save</i> Simpan User
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
