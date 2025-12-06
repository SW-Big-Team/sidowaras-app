@extends('layouts.admin.app')

@section('title', 'Daftar Shift')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Shift</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Daftar Shift</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner shift">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge"><i class="material-symbols-rounded">schedule</i> Manajemen Shift</span>
                    <h2 class="welcome-title">Daftar Shift</h2>
                    <p class="welcome-subtitle">Kelola jadwal shift dan penugasan karyawan apotek.</p>
                </div>
                <div class="welcome-stats">
                    <a href="{{ route('admin.users.index') }}" class="stat-pill"><i class="material-symbols-rounded">group</i><span>User</span></a>
                    <button type="button" class="stat-pill primary" data-bs-toggle="modal" data-bs-target="#shiftModal" data-mode="create">
                        <i class="material-symbols-rounded">add</i><span>Tambah Shift</span>
                    </button>
                </div>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">schedule</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">person</i></div>
                <div class="floating-icon icon-3"><i class="material-symbols-rounded">calendar_today</i></div>
            </div>
        </div>
    </div>
</div>

{{-- Metric Cards --}}
<div class="row g-3 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="metric-card primary">
            <div class="metric-icon"><i class="material-symbols-rounded">list_alt</i></div>
            <div class="metric-content"><span class="metric-label">Total Shift</span><h3 class="metric-value">{{ $shifts->count() }}</h3><span class="metric-subtext">Seluruh shift terdaftar</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="metric-card success">
            <div class="metric-icon"><i class="material-symbols-rounded">toggle_on</i></div>
            <div class="metric-content"><span class="metric-label">Shift Aktif</span><h3 class="metric-value">{{ $shifts->where('shift_status', true)->count() }}</h3><span class="metric-subtext">Shift sedang berjalan</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="metric-card info">
            <div class="metric-icon"><i class="material-symbols-rounded">groups</i></div>
            <div class="metric-content"><span class="metric-label">Karyawan Terjadwal</span><h3 class="metric-value">{{ $shifts->sum(function($shift) { return count($shift->user_list ?? []); }) }}</h3><span class="metric-subtext">Total penugasan</span></div>
            <div class="metric-glow"></div>
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
                                <h6 class="mb-0 fw-bold">Data Shift</h6>
                                <span class="badge bg-soft-primary text-primary text-xs fw-bold rounded-pill">
                                    {{ $shifts->count() }} shift
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-stok">
                            <thead class="bg-gradient-dark">
                                <tr>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-4">Nama Shift</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Hari</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Waktu</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Karyawan</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2 text-center">Status</th>
                                    <th class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-9">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($shifts as $shift)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm fw-bold text-dark">{{ $shift->shift_name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $dayColor = match(strtolower($shift->shift_day_of_week)) {
                                                    'minggu' => 'danger',
                                                    'sabtu' => 'warning',
                                                    default => 'primary'
                                                };
                                            @endphp
                                            <span class="badge badge-sm bg-gradient-{{ $dayColor }} text-capitalize">
                                                {{ ucfirst($shift->shift_day_of_week ?? '-') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-xs font-weight-bold text-dark mb-1">
                                                    <i class="material-symbols-rounded text-xxs align-middle me-1">login</i>
                                                    {{ \Carbon\Carbon::parse($shift->shift_start)->format('H:i') }}
                                                </span>
                                                <span class="text-xs font-weight-bold text-secondary">
                                                    <i class="material-symbols-rounded text-xxs align-middle me-1">logout</i>
                                                    {{ \Carbon\Carbon::parse($shift->shift_end)->format('H:i') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="avatar-group mt-2">
                                                @php 
                                                    $users = $shift->users;
                                                    $limit = 4;
                                                    $displayedUsers = $users->take($limit);
                                                    $remaining = $users->count() - $limit;
                                                @endphp
                                                
                                                @if($users->count() > 0)
                                                    @foreach($displayedUsers as $user)
                                                        <a href="javascript:;" 
                                                           class="avatar avatar-xs rounded-circle" 
                                                           data-bs-toggle="tooltip" 
                                                           data-bs-placement="bottom" 
                                                           title="{{ $user->nama_lengkap }}">
                                                            <img alt="{{ $user->nama_lengkap }}" 
                                                                 src="https://ui-avatars.com/api/?name={{ urlencode($user->nama_lengkap) }}&background=random&color=fff&size=64"
                                                                 class="rounded-circle">
                                                        </a>
                                                    @endforeach
                                                    
                                                    @if($remaining > 0)
                                                        <a href="javascript:;" 
                                                           class="avatar avatar-xs rounded-circle bg-gradient-secondary text-white" 
                                                           data-bs-toggle="tooltip" 
                                                           data-bs-placement="bottom" 
                                                           title="{{ $remaining }} karyawan lainnya">
                                                            <span class="text-xxs fw-bold">+{{ $remaining }}</span>
                                                        </a>
                                                    @endif
                                                @else
                                                    <span class="text-xs text-secondary fst-italic">Belum ada</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('admin.shift.toggle-status', $shift->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="border-0 bg-transparent p-0 cursor-pointer" title="Klik untuk mengubah status">
                                                    @if($shift->shift_status)
                                                        <span class="badge badge-sm bg-soft-success text-success">
                                                            <i class="material-symbols-rounded text-xxs me-1 align-middle">check_circle</i>Aktif
                                                        </span>
                                                    @else
                                                        <span class="badge badge-sm bg-soft-secondary text-secondary">
                                                            <i class="material-symbols-rounded text-xxs me-1 align-middle">cancel</i>Non-Aktif
                                                        </span>
                                                    @endif
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <button type="button"
                                                    class="btn btn-link text-warning px-3 mb-0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#shiftModal"
                                                    data-mode="edit"
                                                    data-id="{{ $shift->id }}"
                                                    data-shift-name="{{ $shift->shift_name }}"
                                                    data-shift-day="{{ $shift->shift_day_of_week }}"
                                                    data-shift-start="{{ \Carbon\Carbon::parse($shift->shift_start)->format('H:i') }}"
                                                    data-shift-end="{{ \Carbon\Carbon::parse($shift->shift_end)->format('H:i') }}"
                                                    data-shift-status="{{ $shift->shift_status ? '1' : '0' }}"
                                                    data-user-list="{{ json_encode($shift->user_list ?? []) }}"
                                                    title="Edit">
                                                    <i class="material-symbols-rounded text-sm">edit</i>
                                                </button>
                                                <form action="{{ route('admin.shift.destroy', $shift->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Yakin ingin menghapus shift {{ $shift->shift_name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-link text-danger px-3 mb-0"
                                                            title="Hapus">
                                                        <i class="material-symbols-rounded text-sm">delete</i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div class="icon icon-lg icon-shape bg-light shadow-sm rounded-circle mb-3">
                                                    <i class="material-symbols-rounded text-secondary opacity-5" style="font-size: 2rem;">schedule</i>
                                                </div>
                                                <h6 class="text-secondary mb-1">Belum ada data shift</h6>
                                                <p class="text-xs text-secondary">Silakan tambahkan shift baru</p>
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

    <!-- Modal: Create/Edit Shift -->
    <div class="modal fade" id="shiftModal" tabindex="-1" aria-labelledby="shiftModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-dark">
                    <h5 class="modal-title text-white" id="shiftModalLabel">
                        <i class="material-symbols-rounded me-2 align-middle">schedule</i>
                        Tambah Shift
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="shiftForm" method="POST" action="{{ session('_edit_id') ? route('admin.shift.update', session('_edit_id')) : route('admin.shift.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="shiftFormMethod" value="{{ session('_edit_id') ? 'PUT' : 'POST' }}">
                    <div class="modal-body p-4" style="max-height: 75vh; overflow-y: auto;">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                                <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
                                <span class="alert-text">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Informasi Shift -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon icon-shape bg-soft-primary text-primary shadow-none text-center border-radius-md me-3">
                                    <i class="material-symbols-rounded text-lg">schedule</i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">Informasi Shift</h6>
                                    <p class="text-xs text-secondary mb-0">Atur detail jadwal shift</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Nama Shift <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <input type="text" 
                                               class="form-control @error('shift_name') is-invalid @enderror" 
                                               name="shift_name" 
                                               id="shift_name" 
                                               value="{{ old('shift_name') }}"
                                               placeholder="Contoh: Shift Pagi" 
                                               required>
                                    </div>
                                    @error('shift_name')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Hari <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <select class="form-control @error('shift_day_of_week') is-invalid @enderror" 
                                                name="shift_day_of_week" 
                                                id="shift_day_of_week" 
                                                required>
                                            <option value="">-- Pilih --</option>
                                            <option value="senin" {{ old('shift_day_of_week') == 'senin' ? 'selected' : '' }}>Senin</option>
                                            <option value="selasa" {{ old('shift_day_of_week') == 'selasa' ? 'selected' : '' }}>Selasa</option>
                                            <option value="rabu" {{ old('shift_day_of_week') == 'rabu' ? 'selected' : '' }}>Rabu</option>
                                            <option value="kamis" {{ old('shift_day_of_week') == 'kamis' ? 'selected' : '' }}>Kamis</option>
                                            <option value="jumat" {{ old('shift_day_of_week') == 'jumat' ? 'selected' : '' }}>Jumat</option>
                                            <option value="sabtu" {{ old('shift_day_of_week') == 'sabtu' ? 'selected' : '' }}>Sabtu</option>
                                            <option value="minggu" {{ old('shift_day_of_week') == 'minggu' ? 'selected' : '' }}>Minggu</option>
                                        </select>
                                    </div>
                                    @error('shift_day_of_week')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Waktu Mulai <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <input type="time" 
                                               class="form-control @error('shift_start') is-invalid @enderror" 
                                               name="shift_start" 
                                               id="shift_start" 
                                               value="{{ old('shift_start') }}"
                                               required>
                                    </div>
                                    @error('shift_start')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Waktu Selesai <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <input type="time" 
                                               class="form-control @error('shift_end') is-invalid @enderror" 
                                               name="shift_end" 
                                               id="shift_end" 
                                               value="{{ old('shift_end') }}"
                                               required>
                                    </div>
                                    @error('shift_end')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status Shift -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon icon-shape bg-soft-warning text-warning shadow-none text-center border-radius-md me-3">
                                    <i class="material-symbols-rounded text-lg">toggle_on</i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">Status Shift</h6>
                                    <p class="text-xs text-secondary mb-0">Aktifkan atau nonaktifkan shift</p>
                                </div>
                            </div>

                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-0" type="checkbox" name="shift_status" value="1" {{ old('shift_status', '1') ? 'checked' : '' }} id="shift_status">
                                <label class="form-check-label ms-3 text-sm fw-bold text-dark" for="shift_status">
                                    Aktifkan shift
                                </label>
                            </div>
                        </div>

                        <!-- Daftar Karyawan -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon icon-shape bg-soft-success text-success shadow-none text-center border-radius-md me-3">
                                    <i class="material-symbols-rounded text-lg">groups</i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">Daftar Karyawan</h6>
                                    <p class="text-xs text-secondary mb-0">Pilih karyawan untuk shift ini</p>
                                </div>
                            </div>

                            @if($karyawanUsers->count() > 0)
                                <div class="mb-3">
                                    <div class="input-group input-group-outline mb-2">
                                        <span class="input-group-text">
                                            <i class="material-symbols-rounded">search</i>
                                        </span>
                                        <input type="text" 
                                               class="form-control" 
                                               id="userSearchInput" 
                                               placeholder="Cari karyawan...">
                                    </div>
                                </div>
                                
                                <div class="card border shadow-none bg-gray-100" style="max-height: 350px; overflow-y: auto;">
                                    <div class="card-body p-3">
                                        <div class="row g-2" id="userListContainer">
                                            @foreach($karyawanUsers as $user)
                                                <div class="col-md-6 user-item" 
                                                     data-name="{{ strtolower($user->nama_lengkap) }}" 
                                                     data-email="{{ strtolower($user->email) }}">
                                                    <div class="card border-0 shadow-sm user-card h-100 cursor-pointer position-relative overflow-hidden" onclick="document.getElementById('user_{{ $user->id }}').click()">
                                                        <div class="card-body p-3 d-flex align-items-center">
                                                            <div class="form-check ps-0 m-0 me-3">
                                                                <input class="form-check-input user-checkbox ms-0" 
                                                                       type="checkbox" 
                                                                       name="user_list[]" 
                                                                       value="{{ $user->id }}" 
                                                                       id="user_{{ $user->id }}"
                                                                       {{ in_array($user->id, old('user_list', [])) ? 'checked' : '' }}
                                                                       onclick="event.stopPropagation()">
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <span class="text-sm fw-bold text-dark">{{ $user->nama_lengkap }}</span>
                                                                <span class="text-xs text-muted">{{ $user->email }}</span>
                                                            </div>
                                                            <div class="ms-auto">
                                                                <span class="badge bg-soft-secondary text-secondary text-xxs">Karyawan</span>
                                                            </div>
                                                        </div>
                                                        <div class="selected-indicator"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 d-flex justify-content-between align-items-center">
                                    <small class="text-muted text-xs">
                                        <span id="selectedCount" class="fw-bold text-primary">0</span> karyawan dipilih
                                    </small>
                                    <button type="button" class="btn btn-link btn-sm text-secondary mb-0 p-0" onclick="document.querySelectorAll('.user-checkbox').forEach(c => c.checked = false); updateSelectedCount();">
                                        Reset Pilihan
                                    </button>
                                </div>
                                @error('user_list')
                                    <div class="text-danger text-xs mt-2">{{ $message }}</div>
                                @enderror
                                <div id="userListError" class="text-danger text-xs mt-2" style="display: none;"></div>
                            @else
                                <div class="alert alert-warning text-white" role="alert">
                                    <div class="d-flex align-items-center">
                                        <span class="alert-icon me-2"><i class="material-symbols-rounded">warning</i></span>
                                        <span class="alert-text text-sm">Tidak ada karyawan aktif yang tersedia. Silakan buat user dengan role "Karyawan" terlebih dahulu.</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer border-top p-3">
                        <button type="button" class="btn btn-outline-secondary mb-0 d-flex align-items-center gap-1" data-bs-dismiss="modal">
                            <i class="material-symbols-rounded text-sm">close</i> Batal
                        </button>
                        <button type="submit" class="btn bg-gradient-primary mb-0 d-flex align-items-center gap-1" id="shiftSubmitBtn" {{ $karyawanUsers->count() == 0 ? 'disabled' : '' }}>
                            <i class="material-symbols-rounded text-sm">save</i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    (function() {
        const modalEl = document.getElementById('shiftModal');
        if (!modalEl) return;
        
        // User search functionality
        function updateUserListVisibility(searchTerm) {
            const searchLower = searchTerm.toLowerCase();
            const userItems = document.querySelectorAll('.user-item');
            
            userItems.forEach(item => {
                const name = item.getAttribute('data-name') || '';
                const email = item.getAttribute('data-email') || '';
                
                if (name.includes(searchLower) || email.includes(searchLower)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
            const countEl = document.getElementById('selectedCount');
            
            if (countEl) {
                countEl.textContent = checkedCount;
            }

            // Update card styling based on selection
            checkboxes.forEach(cb => {
                const card = cb.closest('.user-card');
                if (card) {
                    if (cb.checked) {
                        card.classList.add('border-primary', 'bg-soft-primary');
                        card.classList.remove('border-0', 'shadow-sm');
                        card.classList.add('shadow-md');
                    } else {
                        card.classList.remove('border-primary', 'bg-soft-primary', 'shadow-md');
                        card.classList.add('border-0', 'shadow-sm');
                    }
                }
            });
        }
        
        // Auto-open modal if there are validation errors
        @if ($errors->any())
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
            
            // Set form to edit mode if editing
            @if(session('_edit_id'))
                const form = document.getElementById('shiftForm');
                const methodInput = document.getElementById('shiftFormMethod');
                const titleEl = document.getElementById('shiftModalLabel');
                const submitBtn = document.getElementById('shiftSubmitBtn');
                
                form.action = "{{ route('admin.shift.update', session('_edit_id')) }}";
                methodInput.value = 'PUT';
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2 align-middle">schedule</i> Edit Shift';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1 text-sm">update</i> Update';
            @endif
            
            // Update selected count after modal is shown
            setTimeout(() => {
                updateSelectedCount();
            }, 300);
        @endif

        modalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const mode = button?.getAttribute('data-mode') || 'create';
            const form = document.getElementById('shiftForm');
            const methodInput = document.getElementById('shiftFormMethod');
            const titleEl = document.getElementById('shiftModalLabel');
            const submitBtn = document.getElementById('shiftSubmitBtn');
            const shiftNameInput = document.getElementById('shift_name');
            const shiftDayInput = document.getElementById('shift_day_of_week');
            const shiftStartInput = document.getElementById('shift_start');
            const shiftEndInput = document.getElementById('shift_end');
            const shiftStatusInput = document.getElementById('shift_status');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            const userListError = document.getElementById('userListError');
            const userSearchInput = document.getElementById('userSearchInput');

            // Clear previous errors (only if not from validation)
            if (userListError && !button) {
                userListError.style.display = 'none';
                userListError.textContent = '';
            }

            // Only populate from button data if button exists (not validation error redirect)
            if (button && mode === 'edit') {
                const id = button.getAttribute('data-id');
                form.action = "{{ url('adminx/shift') }}/" + id;
                methodInput.value = 'PUT';
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2 align-middle">schedule</i> Edit Shift';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1 text-sm">update</i> Update';
                
                // Populate form fields
                shiftNameInput.value = button.getAttribute('data-shift-name') || '';
                shiftDayInput.value = button.getAttribute('data-shift-day') || '';
                shiftStartInput.value = button.getAttribute('data-shift-start') || '';
                shiftEndInput.value = button.getAttribute('data-shift-end') || '';
                
                const shiftStatus = button.getAttribute('data-shift-status');
                shiftStatusInput.checked = shiftStatus === '1';
                
                // Handle user_list
                try {
                    const userList = JSON.parse(button.getAttribute('data-user-list') || '[]');
                    userCheckboxes.forEach(checkbox => {
                        checkbox.checked = userList.includes(parseInt(checkbox.value));
                    });
                    updateSelectedCount();
                } catch (e) {
                    console.error('Error parsing user_list:', e);
                }
                
                // Clear search when editing
                if (userSearchInput) {
                    userSearchInput.value = '';
                    updateUserListVisibility('');
                }
            } else if (button) {
                // Create mode (only if button exists)
                form.action = "{{ route('admin.shift.store') }}";
                methodInput.value = 'POST';
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2 align-middle">schedule</i> Tambah Shift';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1 text-sm">save</i> Simpan';
                
                // Clear form fields only if no old values (from validation errors)
                @if(!old('shift_name'))
                    shiftNameInput.value = '';
                    shiftDayInput.value = '';
                    shiftStartInput.value = '';
                    shiftEndInput.value = '';
                    shiftStatusInput.checked = true;
                    
                    // Uncheck all user checkboxes
                    userCheckboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    
                    // Clear search
                    if (userSearchInput) {
                        userSearchInput.value = '';
                        updateUserListVisibility('');
                    }
                    
                    updateSelectedCount();
                @endif
            }
        });

        // Search input event - use event delegation
        document.addEventListener('input', function(e) {
            if (e.target && e.target.id === 'userSearchInput') {
                updateUserListVisibility(e.target.value);
            }
        });

        // Update count when checkboxes change - use event delegation
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('user-checkbox')) {
                updateSelectedCount();
            }
        });

        // Validate user_list before submit
        const form = document.getElementById('shiftForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const checkedUsers = document.querySelectorAll('.user-checkbox:checked');
                const userListError = document.getElementById('userListError');
                
                if (checkedUsers.length === 0) {
                    e.preventDefault();
                    if (userListError) {
                        userListError.textContent = 'Pilih minimal satu karyawan untuk shift ini.';
                        userListError.style.display = 'block';
                    }
                    return false;
                } else {
                    if (userListError) {
                        userListError.style.display = 'none';
                    }
                }
            });
        }

        // Clear modal on hide
        modalEl.addEventListener('hidden.bs.modal', function () {
            const form = document.getElementById('shiftForm');
            if (form) {
                form.reset();
            }
            const userListError = document.getElementById('userListError');
            if (userListError) {
                userListError.style.display = 'none';
                userListError.textContent = '';
            }
            // Clear search
            if (userSearchInput) {
                userSearchInput.value = '';
                updateUserListVisibility('');
            }
            updateSelectedCount();
        });
    })();
    </script>
    @endpush

    <style>
:root { --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6; --primary: #8b5cf6; --secondary: #64748b; }
.welcome-banner.shift { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 16px; padding: 2rem; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; }
.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0 0 16px; max-width: 500px; }
.welcome-stats { display: flex; gap: 10px; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; text-decoration: none; border: none; cursor: pointer; transition: all 0.2s; }
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; }
.stat-pill.primary { background: rgba(255,255,255,0.3); }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
.floating-icon.icon-3 { animation-delay: 1s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.metric-card { background: white; border-radius: 16px; padding: 1.25rem; display: flex; gap: 1rem; position: relative; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); transition: all 0.3s ease; }
.metric-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
.metric-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.metric-icon i { font-size: 26px; color: white; }
.metric-card.primary .metric-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.metric-card.success .metric-icon { background: linear-gradient(135deg, #10b981, #059669); }
.metric-card.info .metric-icon { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.metric-content { flex: 1; }
.metric-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; font-weight: 600; }
.metric-value { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 4px 0; }
.metric-subtext { font-size: 0.75rem; color: var(--secondary); }
.metric-glow { position: absolute; top: -50%; right: -50%; width: 100%; height: 200%; border-radius: 50%; opacity: 0.08; }
.metric-card.primary .metric-glow { background: var(--primary); }
.metric-card.success .metric-glow { background: var(--success); }
.metric-card.info .metric-glow { background: var(--info); }
.text-xxs { font-size: 0.65rem !important; }
.shadow-sm-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }
        
        .input-group-outline {
            display: flex;
            width: 100%;
        }
        
        .cursor-pointer {
            cursor: pointer;
        }
        
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
        }
        
        /* User Card Selection */
        .user-card {
            transition: all 0.2s ease;
        }
        .user-card:hover {
            background-color: #f8f9fa;
        }
        .user-card.border-primary {
            border-color: #e91e63 !important; /* Material Primary */
        }
        .bg-soft-primary.user-card {
            background-color: rgba(233, 30, 99, 0.05) !important;
        }
    </style>
</div>
@endsection
