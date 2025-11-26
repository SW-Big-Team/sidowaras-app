<!-- Notifications Modal -->
<div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header pb-0 border-bottom-0">
                <h5 class="modal-title" id="notificationsModalLabel">Notifikasi</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="nav-wrapper position-relative end-0 px-3 pt-2">
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#all-notifications" role="tab" aria-controls="all-notifications" aria-selected="true">
                                Semua
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#unread-notifications" role="tab" aria-controls="unread-notifications" aria-selected="false">
                                Belum Dibaca
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#warning-notifications" role="tab" aria-controls="warning-notifications" aria-selected="false">
                                Penting
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content p-3">
                    <div class="tab-pane fade show active" id="all-notifications" role="tabpanel">
                        @include('layouts.admin.partials.notifications-modal-list', ['items' => $notifications])
                    </div>
                    <div class="tab-pane fade" id="unread-notifications" role="tabpanel">
                        @include('layouts.admin.partials.notifications-modal-list', ['items' => $notifications->where('read_at', null)])
                    </div>
                    <div class="tab-pane fade" id="warning-notifications" role="tabpanel">
                        @include('layouts.admin.partials.notifications-modal-list', ['items' => $notifications->where('is_warning', true)])
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-link text-secondary mb-0" data-bs-dismiss="modal">Tutup</button>
                @if($notifications->count() > 0)
                    <button type="button" class="btn bg-gradient-primary mb-0" onclick="markAllAsReadFromModal()">Tandai Semua Dibaca</button>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
  #notificationsModal .nav-link {
    border-radius: 0.85rem;
    font-weight: 600;
    color: var(--sw-muted);
  }

  #notificationsModal .nav-link.active {
    background: var(--sw-primary);
    color: #fff;
  }

  #notificationsModal .notif-item {
    border: 1px solid rgba(15, 23, 42, 0.08);
    border-radius: 0.85rem;
    padding: 1rem;
    margin-bottom: 0.75rem;
    display: flex;
    gap: 1rem;
    text-decoration: none;
    color: inherit;
  }

  #notificationsModal .notif-item:hover {
    border-color: rgba(29, 78, 216, 0.25);
    background: rgba(37, 99, 235, 0.03);
  }

  #notificationsModal .notif-icon {
    width: 44px;
    height: 44px;
    border-radius: 0.85rem;
    background: var(--sw-primary-soft);
    color: var(--sw-primary);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  #notificationsModal .notif-meta {
    font-size: 0.75rem;
    color: var(--sw-muted);
  }

  #notificationsModal .notif-empty {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--sw-muted);
  }
  
  @media (max-width: 768px) {
    #notificationsModal .modal-dialog {
      margin: 0.5rem;
    }
  }
</style>
@endpush

@push('scripts')
<script>
  function markAsReadFromModal(notificationId) {
    fetch('/notifications/' + notificationId + '/read', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        location.reload();
      }
    })
    .catch(error => console.error('Error:', error));
  }

  function markAllAsReadFromModal() {
    fetch('/notifications/read-all', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
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
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        location.reload();
      }
    })
    .catch(error => console.error('Error:', error));
  }
</script>
@endpush
