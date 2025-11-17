<div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content border-0 rounded-4">
      <div class="modal-header border-0 px-4 pt-4">
        <div>
          <p class="text-xs text-muted mb-1">Aktivitas terbaru</p>
          <h5 class="modal-title fw-semibold" id="notificationsModalLabel">Semua Notifikasi</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0">
        <div class="px-1 pb-3">
          <ul class="nav nav-pills nav-fill gap-2" id="notificationTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all-notifications" type="button" role="tab" aria-controls="all-notifications" aria-selected="true">
                <i class="material-symbols-rounded text-sm me-1">inbox</i>
                Semua ({{ $notifications->count() }})
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="unread-tab" data-bs-toggle="pill" data-bs-target="#unread-notifications" type="button" role="tab" aria-controls="unread-notifications" aria-selected="false">
                <i class="material-symbols-rounded text-sm me-1">mark_email_unread</i>
                Belum Dibaca ({{ $unreadNotificationCount }})
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="warning-tab" data-bs-toggle="pill" data-bs-target="#warning-notifications" type="button" role="tab" aria-controls="warning-notifications" aria-selected="false">
                <i class="material-symbols-rounded text-sm me-1">warning</i>
                Penting
              </button>
            </li>
          </ul>
        </div>

        <div class="tab-content" id="notificationTabsContent">
          <div class="tab-pane fade show active" id="all-notifications" role="tabpanel" aria-labelledby="all-tab">
            @include('layouts.karyawan.partials.notifications-modal-list', ['items' => $notifications])
          </div>
          <div class="tab-pane fade" id="unread-notifications" role="tabpanel" aria-labelledby="unread-tab">
            @include('layouts.karyawan.partials.notifications-modal-list', ['items' => $notifications->where('read_at', null)])
          </div>
          <div class="tab-pane fade" id="warning-notifications" role="tabpanel" aria-labelledby="warning-tab">
            @include('layouts.karyawan.partials.notifications-modal-list', ['items' => $notifications->where('is_warning', true)])
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 px-4 pb-4">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
        @if($notifications->count() > 0)
          <button type="button" class="btn btn-primary" onclick="markAllAsReadFromModal()">Tandai Semua Dibaca</button>
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
    fetch('/notifications/' + notificationId + '/mark-read', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
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
    fetch('/notifications/mark-all-read', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
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
</script>
@endpush

<script>
// Function to mark notification as read from modal
function markAsReadFromModal(notificationId) {
  // Add your AJAX call here to mark notification as read
  fetch('/notifications/' + notificationId + '/mark-read', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Reload page to update notification count and list
      location.reload();
    }
  })
  .catch(error => console.error('Error:', error));
}

// Function to mark all notifications as read from modal
function markAllAsReadFromModal() {
  fetch('/notifications/mark-all-read', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Close modal and reload page
      const modal = bootstrap.Modal.getInstance(document.getElementById('notificationsModal'));
      if (modal) {
        modal.hide();
      }
      location.reload();
    }
  })
  .catch(error => console.error('Error:', error));
}
</script>
