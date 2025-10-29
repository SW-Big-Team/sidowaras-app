@extends('layouts.admin.app')

@section('title', 'Dashboard Administrator - Sidowaras App')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

	<div class="row">
		<div class="col-md-12">
            <div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<strong>Daftar Supplier</strong>
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#supplierModal" data-mode="create">
						Tambah Supplier
					</button>
				</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Telepon</th>
                                    <th>Email</th>
                                    <th>Website</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $supplier->supplier_name }}</td>
                                        <td>{{ $supplier->supplier_phone }}</td>
                                        <td>{{ $supplier->supplier_email }}</td>
                                        <td>{{ $supplier->supplier_website }}</td>
                                        <td>
                                            <span class="badge {{ $supplier->supplier_status ? 'bg-success' : 'bg-secondary' }}">{{ $supplier->supplier_status ? 'Aktif' : 'Nonaktif' }}</span>
                                        </td>
                                        <td class="text-end">
											<button type="button"
												class="btn btn-sm btn-warning"
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
											>
												Edit
											</button>
                                            <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus supplier ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center p-3">Belum ada data supplier.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(method_exists($suppliers, 'links'))
                    <div class="card-footer">{{ $suppliers->links() }}</div>
                @endif
            </div>
        </div>
    </div>

	<!-- Modal: Create/Edit Supplier -->
	<div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="supplierModalLabel">Tambah Supplier</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="supplierForm" method="post" action="{{ route('admin.suppliers.store') }}">
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
									<textarea class="form-control" name="supplier_address" id="supplier_address" rows="2" placeholder="Masukkan alamat"></textarea>
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
								<div class="form-check form-switch">
									<input class="form-check-input" type="checkbox" name="supplier_status" value="1" checked id="supplier_status_modal">
									<label class="form-check-label" for="supplier_status_modal">Aktif</label>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary" id="supplierSubmitBtn">Simpan</button>
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
				form.action = "{{ url('adminx/suppliers') }}/" + id;
				methodInput.value = 'PUT';
				titleEl.textContent = 'Edit Supplier';
				submitBtn.textContent = 'Update';

				f.name.value = button.getAttribute('data-name') || '';
				f.phone.value = button.getAttribute('data-phone') || '';
				f.address.value = button.getAttribute('data-address') || '';
				f.email.value = button.getAttribute('data-email') || '';
				f.website.value = button.getAttribute('data-website') || '';
				f.logo.value = button.getAttribute('data-logo') || '';
				f.status.checked = (button.getAttribute('data-status') === '1');
			} else {
				form.action = "{{ route('admin.suppliers.store') }}";
				methodInput.value = 'POST';
				titleEl.textContent = 'Tambah Supplier';
				submitBtn.textContent = 'Simpan';

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