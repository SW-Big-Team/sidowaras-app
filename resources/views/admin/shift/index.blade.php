@extends('layouts.admin.app')

@section('title', 'Daftar Shift')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Shift</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Daftar Shift</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    <x-content-header title="Daftar Shift" subtitle="Kelola jadwal shift karyawan">
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.users.index') }}" class="btn bg-gradient-secondary mb-0">
                <i class="material-symbols-rounded text-sm me-1">people</i> User
            </a>
            <button type="button" 
                    class="btn bg-gradient-primary mb-0" 
                    data-bs-toggle="modal" 
                    data-bs-target="#shiftModal" 
                    data-mode="create">
                <i class="material-symbols-rounded text-sm me-1">add</i> Tambah Shift
            </button>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Shift</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Hari</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu Mulai</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu Selesai</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah Karyawan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </x-slot>

                        @forelse ($shifts as $shift)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $shift->shift_name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-sm bg-gradient-primary text-capitalize">
                                        {{ ucfirst($shift->shift_day_of_week ?? '-') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <p class="text-sm mb-0">{{ \Carbon\Carbon::parse($shift->shift_start)->format('H:i') }}</p>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm mb-0">{{ \Carbon\Carbon::parse($shift->shift_end)->format('H:i') }}</p>
                                </td>
                                <td>
                                    <span class="badge badge-sm bg-gradient-info">
                                        {{ is_array($shift->user_list) ? count($shift->user_list) : 0 }} Karyawan
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($shift->shift_status)
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
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="material-symbols-rounded text-muted mb-2" style="font-size: 3rem;">schedule</i>
                                        <p class="text-sm text-muted mb-0">Belum ada data shift</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </x-data-table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Create/Edit Shift -->
    <div class="modal fade" id="shiftModal" tabindex="-1" aria-labelledby="shiftModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="shiftModalLabel">
                        <i class="material-symbols-rounded me-2">schedule</i>
                        Tambah Shift
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="shiftForm" method="POST" action="{{ session('_edit_id') ? route('admin.shift.update', session('_edit_id')) : route('admin.shift.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="shiftFormMethod" value="{{ session('_edit_id') ? 'PUT' : 'POST' }}">
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="material-symbols-rounded">error</i></span>
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
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md me-3">
                                    <i class="material-symbols-rounded opacity-10">schedule</i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Informasi Shift</h6>
                                    <p class="text-sm text-secondary mb-0">Data jadwal shift</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Nama Shift <span class="text-danger">*</span></label>
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
                                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Hari <span class="text-danger">*</span></label>
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
                                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Waktu Mulai <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <input type="time" 
                                               class="form-control @error('shift_start') is-invalid @enderror" 
                                               name="shift_start" 
                                               id="shift_start" 
                                               value="{{ old('shift_start') }}"
                                               required>
                                    </div>
                                    @error('shift_start')
                                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Waktu Selesai <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <input type="time" 
                                               class="form-control @error('shift_end') is-invalid @enderror" 
                                               name="shift_end" 
                                               id="shift_end" 
                                               value="{{ old('shift_end') }}"
                                               required>
                                    </div>
                                    @error('shift_end')
                                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status Shift -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md me-3">
                                    <i class="material-symbols-rounded opacity-10">toggle_on</i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Status Shift</h6>
                                    <p class="text-sm text-secondary mb-0">Aktifkan atau nonaktifkan shift</p>
                                </div>
                            </div>

                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-0" type="checkbox" name="shift_status" value="1" {{ old('shift_status', '1') ? 'checked' : '' }} id="shift_status">
                                <label class="form-check-label ms-3" for="shift_status">
                                    <span class="text-sm">Aktifkan shift</span>
                                </label>
                            </div>
                        </div>

                        <!-- Daftar Karyawan -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md me-3">
                                    <i class="material-symbols-rounded opacity-10">people</i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Daftar Karyawan</h6>
                                    <p class="text-sm text-secondary mb-0">Pilih karyawan untuk shift ini</p>
                                </div>
                            </div>

                            @if($karyawanUsers->count() > 0)
                                <div class="mb-3">
                                    <label class="form-label text-sm font-weight-bold mb-2">Cari Karyawan</label>
                                    <div class="input-group input-group-outline mb-2">
                                        <span class="input-group-text">
                                            <i class="material-symbols-rounded">search</i>
                                        </span>
                                        <input type="text" 
                                               class="form-control" 
                                               id="userSearchInput" 
                                               placeholder="Ketik nama atau email untuk mencari...">
                                    </div>
                                </div>
                                
                                <div class="card border" style="max-height: 300px; overflow-y: auto;">
                                    <div class="card-body">
                                        <div class="row" id="userListContainer">
                                            @foreach($karyawanUsers as $user)
                                                <div class="col-md-6 mb-2 user-item" 
                                                     data-name="{{ strtolower($user->nama_lengkap) }}" 
                                                     data-email="{{ strtolower($user->email) }}">
                                                    <div class="form-check">
                                                        <input class="form-check-input user-checkbox" 
                                                               type="checkbox" 
                                                               name="user_list[]" 
                                                               value="{{ $user->id }}" 
                                                               id="user_{{ $user->id }}"
                                                               {{ in_array($user->id, old('user_list', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="user_{{ $user->id }}">
                                                            <strong>{{ $user->nama_lengkap }}</strong>
                                                            <br>
                                                            <small class="text-muted">{{ $user->email }}</small>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <span id="selectedCount">0</span> karyawan dipilih
                                    </small>
                                </div>
                                @error('user_list')
                                    <div class="text-danger text-sm mt-2">{{ $message }}</div>
                                @enderror
                                <div id="userListError" class="text-danger text-sm mt-2" style="display: none;"></div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="material-symbols-rounded me-2">warning</i>
                                    Tidak ada karyawan aktif yang tersedia. Silakan buat user dengan role "Karyawan" terlebih dahulu.
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">
                            <i class="material-symbols-rounded me-1">close</i> Batal
                        </button>
                        <button type="submit" class="btn bg-gradient-primary mb-0" id="shiftSubmitBtn" {{ $karyawanUsers->count() == 0 ? 'disabled' : '' }}>
                            <i class="material-symbols-rounded me-1">save</i> Simpan
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
            const checked = document.querySelectorAll('.user-checkbox:checked').length;
            const countEl = document.getElementById('selectedCount');
            if (countEl) {
                countEl.textContent = checked;
            }
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
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2">schedule</i> Edit Shift';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1">update</i> Update';
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
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2">schedule</i> Edit Shift';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1">update</i> Update';
                
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
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2">schedule</i> Tambah Shift';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1">save</i> Simpan';
                
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
</div>
@endsection
