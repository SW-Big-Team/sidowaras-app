@extends('layouts.admin.app')
@section('title', 'Daftar Supplier')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Data</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Supplier</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    <x-content-header title="Daftar Supplier" subtitle="Kelola data supplier dan pemasok obat">
        <button type="button" 
                class="btn bg-gradient-primary mb-0" 
                data-bs-toggle="modal" 
                data-bs-target="#supplierModal" 
                data-mode="create">
            <i class="material-symbols-rounded text-sm">add_circle</i>
            <span class="ms-1">Tambah Supplier</span>
        </button>
    </x-content-header>

    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-icon"><i class="material-symbols-rounded">check_circle</i></span>
                    <span class="alert-text">{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-icon"><i class="material-symbols-rounded">error</i></span>
                    <span class="alert-text">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <x-data-table :headers="['#', 'Nama Supplier', 'Telepon', 'Email', 'Website', 'Status', 'Aksi']">
                @forelse($suppliers as $index => $supplier)
                    <tr>
                        <td class="ps-4">
                            <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                        </td>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">{{ $supplier->supplier_name }}</h6>
                                    @if($supplier->supplier_address)
                                        <p class="text-xs text-secondary mb-0">{{ Str::limit($supplier->supplier_address, 50) }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs text-secondary mb-0">{{ $supplier->supplier_phone }}</p>
                        </td>
                        <td>
                            <p class="text-xs text-secondary mb-0">{{ $supplier->supplier_email }}</p>
                        </td>
                        <td>
                            <p class="text-xs text-secondary mb-0">{{ $supplier->supplier_website ?? '-' }}</p>
                        </td>
                        <td>
                            @if($supplier->supplier_status)
                                <span class="badge badge-sm bg-gradient-success">Aktif</span>
                            @else
                                <span class="badge badge-sm bg-gradient-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button"
                                    class="btn btn-link text-warning px-3 mb-0"
                                    data-bs-toggle="modal"
                                    data-bs-target="#supplierModal"
                                    data-mode="edit"
                                    data-id="{{ $supplier->id }}"
                                    data-name="{{ $supplier->supplier_name }}"
                                    data-phone="{{ $supplier->supplier_phone }}"
                                    data-address="{{ $supplier->supplier_address }}"
                                    data-email="{{ $supplier->supplier_email }}"
                                    data-website="{{ $supplier->supplier_website }}"
                                    data-logo="{{ $supplier->supplier_logo }}"
                                    data-status="{{ $supplier->supplier_status ? 1 : 0 }}"
                                    title="Edit">
                                    <i class="material-symbols-rounded text-sm">edit</i>
                                </button>
                                <form action="{{ route('admin.supplier.destroy', $supplier->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Yakin ingin menghapus supplier {{ $supplier->supplier_name }}?')">
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
                            <i class="material-symbols-rounded text-secondary" style="font-size: 3rem;">local_shipping</i>
                            <p class="text-secondary mb-0">Belum ada data supplier</p>
                        </td>
                    </tr>
                @endforelse
            </x-data-table>
        </div>
    </div>

	<!-- Modal: Create/Edit Supplier -->
	<div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header bg-gradient-primary">
					<h5 class="modal-title text-white" id="supplierModalLabel">
						<i class="material-symbols-rounded me-2">local_shipping</i>
						Tambah Supplier
					</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="supplierForm" method="post" action="{{ route('admin.supplier.store') }}">
					@csrf
					<input type="hidden" name="_method" id="supplierFormMethod" value="POST">
					<div class="modal-body">
						<div class="row g-3">
							<div class="col-md-6">
								<label class="form-label text-sm font-weight-bold">Nama Supplier <span class="text-danger">*</span></label>
								<div class="input-group input-group-outline">
									<input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Masukkan nama supplier" required>
								</div>
							</div>
							<div class="col-md-6">
								<label class="form-label text-sm font-weight-bold">No. Telepon <span class="text-danger">*</span></label>
								<div class="input-group input-group-outline">
									<input type="text" class="form-control" name="supplier_phone" id="supplier_phone" placeholder="Masukkan no. telepon" required>
								</div>
							</div>
							<div class="col-md-12">
								<label class="form-label text-sm font-weight-bold">Alamat</label>
								<div class="input-group input-group-outline">
									<textarea class="form-control" name="supplier_address" id="supplier_address" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<label class="form-label text-sm font-weight-bold">Email</label>
								<div class="input-group input-group-outline">
									<input type="email" class="form-control" name="supplier_email" id="supplier_email" placeholder="nama@domain.com">
								</div>
							</div>
							<div class="col-md-6">
								<label class="form-label text-sm font-weight-bold">Website</label>
								<div class="input-group input-group-outline">
									<input type="text" class="form-control" name="supplier_website" id="supplier_website" placeholder="https://example.com">
								</div>
							</div>
							<div class="col-md-6">
								<label class="form-label text-sm font-weight-bold">Logo (URL/Path)</label>
								<div class="input-group input-group-outline">
									<input type="text" class="form-control" name="supplier_logo" id="supplier_logo" placeholder="/path/to/logo.png atau URL">
								</div>
							</div>
							<div class="col-md-6">
								<label class="form-label text-sm font-weight-bold">Status</label>
								<div class="form-check form-switch ps-0 mt-2">
									<input class="form-check-input ms-0" type="checkbox" name="supplier_status" value="1" checked id="supplier_status_modal">
									<label class="form-check-label ms-3" for="supplier_status_modal">
										<span class="text-sm">Aktif</span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">
							<i class="material-symbols-rounded me-1">close</i> Batal
						</button>
						<button type="submit" class="btn bg-gradient-primary mb-0" id="supplierSubmitBtn">
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
		const modalEl = document.getElementById('supplierModal');
		if (!modalEl) return;
		modalEl.addEventListener('show.bs.modal', function (event) {
			const button = event.relatedTarget;
			const mode = button?.getAttribute('data-mode') || 'create';
			const form = document.getElementById('supplierForm');
			const methodInput = document.getElementById('supplierFormMethod');
			const titleEl = document.getElementById('supplierModalLabel');
			const submitBtn = document.getElementById('supplierSubmitBtn');

			// fields
			const f = {
				name: document.getElementById('supplier_name'),
				phone: document.getElementById('supplier_phone'),
				address: document.getElementById('supplier_address'),
				email: document.getElementById('supplier_email'),
				website: document.getElementById('supplier_website'),
				logo: document.getElementById('supplier_logo'),
				status: document.getElementById('supplier_status_modal'),
			};

			if (mode === 'edit') {
				const id = button.getAttribute('data-id');
				form.action = "{{ url('adminx/supplier') }}/" + id;
				methodInput.value = 'PUT';
				titleEl.innerHTML = '<i class="material-symbols-rounded me-2">local_shipping</i> Edit Supplier';
				submitBtn.innerHTML = '<i class="material-symbols-rounded me-1">update</i> Update';

				f.name.value = button.getAttribute('data-name') || '';
				f.phone.value = button.getAttribute('data-phone') || '';
				f.address.value = button.getAttribute('data-address') || '';
				f.email.value = button.getAttribute('data-email') || '';
				f.website.value = button.getAttribute('data-website') || '';
				f.logo.value = button.getAttribute('data-logo') || '';
				f.status.checked = (button.getAttribute('data-status') === '1');
			} else {
				form.action = "{{ route('admin.supplier.store') }}";
				methodInput.value = 'POST';
				titleEl.innerHTML = '<i class="material-symbols-rounded me-2">local_shipping</i> Tambah Supplier';
				submitBtn.innerHTML = '<i class="material-symbols-rounded me-1">save</i> Simpan';

				f.name.value = '';
				f.phone.value = '';
				f.address.value = '';
				f.email.value = '';
				f.website.value = '';
				f.logo.value = '';
				f.status.checked = true;
			}
		});
	})();
	</script>
	@endpush
</div>
@endsection