<!-- Modern Notifications Modal -->
<div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content notif-modal">
            <div class="notif-modal-header">
                <div class="header-left">
                    <div class="header-icon"><i class="material-symbols-rounded">notifications</i></div>
                    <div>
                        <h5 class="header-title">Notifikasi</h5>
                        <span class="header-subtitle">{{ $notifications->count() }} notifikasi</span>
                    </div>
                </div>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="material-symbols-rounded">close</i>
                </button>
            </div>

            <div class="notif-tabs">
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#all-notifications" role="tab">
                            <i class="material-symbols-rounded">inbox</i> Semua
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#unread-notifications" role="tab">
                            <i class="material-symbols-rounded">mark_email_unread</i> Belum Dibaca
                            @if($notifications->whereNull('read_at')->count() > 0)
                                <span class="tab-badge">{{ $notifications->whereNull('read_at')->count() }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#warning-notifications" role="tab">
                            <i class="material-symbols-rounded">priority_high</i> Penting
                        </a>
                    </li>
                </ul>
            </div>

            <div class="modal-body notif-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="all-notifications" role="tabpanel">
                        @include('layouts.karyawan.partials.notifications-modal-list', ['items' => $notifications])
                    </div>
                    <div class="tab-pane fade" id="unread-notifications" role="tabpanel">
                        @include('layouts.karyawan.partials.notifications-modal-list', ['items' => $notifications->where('read_at', null)])
                    </div>
                    <div class="tab-pane fade" id="warning-notifications" role="tabpanel">
                        @include('layouts.karyawan.partials.notifications-modal-list', ['items' => $notifications->where('is_warning', true)])
                    </div>
                </div>
            </div>

            <div class="notif-modal-footer">
                <button type="button" class="btn-secondary-pro" data-bs-dismiss="modal">
                    <i class="material-symbols-rounded">close</i> Tutup
                </button>
                @if($notifications->count() > 0)
                    <button type="button" class="btn-primary-pro" onclick="markAllAsReadFromModal()">
                        <i class="material-symbols-rounded">done_all</i> Tandai Semua Dibaca
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.notif-modal { border: none; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
.notif-modal-header { display: flex; align-items: center; justify-content: space-between; padding: 1.25rem 1.5rem; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon { width: 44px; height: 44px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.header-icon i { color: white; font-size: 22px; }
.header-title { font-size: 1.1rem; font-weight: 700; color: white; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: rgba(255,255,255,0.8); }
.close-btn { width: 36px; height: 36px; border-radius: 10px; border: none; background: rgba(255,255,255,0.2); color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
.close-btn:hover { background: rgba(255,255,255,0.3); }
.notif-tabs { padding: 1rem 1.25rem 0; background: #fafbfc; border-bottom: 1px solid #e2e8f0; }
.notif-tabs .nav-pills { gap: 8px; }
.notif-tabs .nav-link { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 10px; font-size: 0.8rem; font-weight: 500; color: #64748b; background: transparent; border: 1px solid transparent; transition: all 0.2s; }
.notif-tabs .nav-link i { font-size: 18px; }
.notif-tabs .nav-link.active { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; border-color: transparent; }
.notif-tabs .nav-link:hover:not(.active) { background: #f1f5f9; color: #1e293b; }
.tab-badge { background: #ef4444; color: white; font-size: 0.65rem; padding: 2px 6px; border-radius: 8px; font-weight: 700; }
.notif-body { padding: 1rem; max-height: 400px; overflow-y: auto; }
.notif-modal-footer { display: flex; justify-content: flex-end; gap: 10px; padding: 1rem 1.25rem; background: #fafbfc; border-top: 1px solid #e2e8f0; }
.btn-secondary-pro { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: white; color: #64748b; font-size: 0.85rem; font-weight: 500; border-radius: 10px; border: 1px solid #e2e8f0; cursor: pointer; transition: all 0.2s; }
.btn-secondary-pro:hover { background: #f8fafc; color: #1e293b; }
.btn-primary-pro { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; font-size: 0.85rem; font-weight: 500; border-radius: 10px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-primary-pro:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(59,130,246,0.3); }
.btn-primary-pro i, .btn-secondary-pro i { font-size: 18px; }
</style>

@push('scripts')
<script>
function markAsReadFromModal(notificationId) {
    fetch('/notifications/' + notificationId + '/read', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(response => response.json())
    .then(data => { if (data.success) location.reload(); })
    .catch(error => console.error('Error:', error));
}

function markAllAsReadFromModal() {
    fetch('/notifications/read-all', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('notificationsModal'));
            if (modalInstance) modalInstance.hide();
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteNotification(notificationId) {
    if (!confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) return;
    fetch('/notifications/' + notificationId, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(response => response.json())
    .then(data => { if (data.success) location.reload(); })
    .catch(error => console.error('Error:', error));
}
</script>
@endpush
