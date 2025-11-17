<!-- Notifications Modal -->
<div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary">
        <h5 class="modal-title text-white" id="notificationsModalLabel">
          <i class="material-symbols-rounded align-middle me-2">notifications</i>
          Semua Notifikasi
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <!-- Filter Tabs -->
        <div class="px-3 pt-3 pb-2 border-bottom">
          <ul class="nav nav-pills nav-fill mb-0" id="notificationTabs" role="tablist">
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

        <!-- Notifications List -->
        <div class="tab-content" id="notificationTabsContent">
          <!-- All Notifications Tab -->
          <div class="tab-pane fade show active" id="all-notifications" role="tabpanel" aria-labelledby="all-tab">
            <div class="list-group list-group-flush">
              @forelse($notifications as $notif)
              <a href="{{ $notif->link ?? '#' }}" 
                 class="list-group-item list-group-item-action border-0 {{ $notif->is_warning ? 'bg-light-warning' : '' }} {{ !$notif->read_at ? 'bg-light' : '' }}"
                 onclick="{{ $notif->is_warning ? 'return true;' : 'markAsReadFromModal(' . $notif->id . '); return true;' }}">
                <div class="d-flex align-items-start py-2">
                  <div class="flex-shrink-0">
                    <div class="icon icon-shape bg-gradient-{{ $notif->icon_color }} shadow text-center border-radius-md me-3 d-flex align-items-center justify-content-center">
                      <i class="material-symbols-rounded text-white">{{ $notif->icon }}</i>
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                      <div>
                        <h6 class="mb-1 text-sm">
                          <span class="font-weight-bold">{{ $notif->title }}</span>
                          @if($notif->is_warning)
                          <span class="badge badge-sm bg-warning ms-1">Penting</span>
                          @endif
                          @if(!$notif->read_at)
                          <span class="badge badge-sm bg-info ms-1">Baru</span>
                          @endif
                        </h6>
                        <p class="text-xs text-secondary mb-1">{{ $notif->message }}</p>
                        <p class="text-xxs text-muted mb-0">
                          <i class="material-symbols-rounded text-xxs align-middle">schedule</i>
                          {{ $notif->created_at->diffForHumans() }}
                        </p>
                      </div>
                      @if(!$notif->read_at)
                      <button type="button" class="btn btn-link btn-sm text-secondary p-0 ms-2" onclick="event.preventDefault(); event.stopPropagation(); markAsReadFromModal({{ $notif->id }});" title="Tandai sudah dibaca">
                        <i class="material-symbols-rounded text-sm">done</i>
                      </button>
                      @endif
                    </div>
                  </div>
                </div>
              </a>
              @empty
              <div class="text-center py-5">
                <i class="material-symbols-rounded text-secondary" style="font-size: 3rem;">notifications_off</i>
                <p class="text-sm text-secondary mt-2 mb-0">Tidak ada notifikasi</p>
              </div>
              @endforelse
            </div>
          </div>

          <!-- Unread Notifications Tab -->
          <div class="tab-pane fade" id="unread-notifications" role="tabpanel" aria-labelledby="unread-tab">
            <div class="list-group list-group-flush">
              @forelse($notifications->where('read_at', null) as $notif)
              <a href="{{ $notif->link ?? '#' }}" 
                 class="list-group-item list-group-item-action border-0 bg-light {{ $notif->is_warning ? 'bg-light-warning' : '' }}"
                 onclick="{{ $notif->is_warning ? 'return true;' : 'markAsReadFromModal(' . $notif->id . '); return true;' }}">
                <div class="d-flex align-items-start py-2">
                  <div class="flex-shrink-0">
                    <div class="icon icon-shape bg-gradient-{{ $notif->icon_color }} shadow text-center border-radius-md me-3 d-flex align-items-center justify-content-center">
                      <i class="material-symbols-rounded text-white">{{ $notif->icon }}</i>
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                      <div>
                        <h6 class="mb-1 text-sm">
                          <span class="font-weight-bold">{{ $notif->title }}</span>
                          @if($notif->is_warning)
                          <span class="badge badge-sm bg-warning ms-1">Penting</span>
                          @endif
                          <span class="badge badge-sm bg-info ms-1">Baru</span>
                        </h6>
                        <p class="text-xs text-secondary mb-1">{{ $notif->message }}</p>
                        <p class="text-xxs text-muted mb-0">
                          <i class="material-symbols-rounded text-xxs align-middle">schedule</i>
                          {{ $notif->created_at->diffForHumans() }}
                        </p>
                      </div>
                      <button type="button" class="btn btn-link btn-sm text-secondary p-0 ms-2" onclick="event.preventDefault(); event.stopPropagation(); markAsReadFromModal({{ $notif->id }});" title="Tandai sudah dibaca">
                        <i class="material-symbols-rounded text-sm">done</i>
                      </button>
                    </div>
                  </div>
                </div>
              </a>
              @empty
              <div class="text-center py-5">
                <i class="material-symbols-rounded text-secondary" style="font-size: 3rem;">mark_email_read</i>
                <p class="text-sm text-secondary mt-2 mb-0">Semua notifikasi sudah dibaca</p>
              </div>
              @endforelse
            </div>
          </div>

          <!-- Warning Notifications Tab -->
          <div class="tab-pane fade" id="warning-notifications" role="tabpanel" aria-labelledby="warning-tab">
            <div class="list-group list-group-flush">
              @forelse($notifications->where('is_warning', true) as $notif)
              <a href="{{ $notif->link ?? '#' }}" 
                 class="list-group-item list-group-item-action border-0 bg-light-warning"
                 onclick="return true;">
                <div class="d-flex align-items-start py-2">
                  <div class="flex-shrink-0">
                    <div class="icon icon-shape bg-gradient-{{ $notif->icon_color }} shadow text-center border-radius-md me-3 d-flex align-items-center justify-content-center">
                      <i class="material-symbols-rounded text-white">{{ $notif->icon }}</i>
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                      <div>
                        <h6 class="mb-1 text-sm">
                          <span class="font-weight-bold">{{ $notif->title }}</span>
                          <span class="badge badge-sm bg-warning ms-1">Penting</span>
                          @if(!$notif->read_at)
                          <span class="badge badge-sm bg-info ms-1">Baru</span>
                          @endif
                        </h6>
                        <p class="text-xs text-secondary mb-1">{{ $notif->message }}</p>
                        <p class="text-xxs text-muted mb-0">
                          <i class="material-symbols-rounded text-xxs align-middle">schedule</i>
                          {{ $notif->created_at->diffForHumans() }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
              @empty
              <div class="text-center py-5">
                <i class="material-symbols-rounded text-secondary" style="font-size: 3rem;">check_circle</i>
                <p class="text-sm text-secondary mt-2 mb-0">Tidak ada notifikasi penting</p>
              </div>
              @endforelse
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
          <i class="material-symbols-rounded text-sm me-1">close</i>
          Tutup
        </button>
        @if($notifications->count() > 0)
        <button type="button" class="btn btn-primary btn-sm" onclick="markAllAsReadFromModal()">
          <i class="material-symbols-rounded text-sm me-1">done_all</i>
          Tandai Semua Dibaca
        </button>
        @endif
      </div>
    </div>
  </div>
</div>

<style>
/* Custom scrollbar untuk modal */
#notificationsModal .modal-body {
  max-height: 60vh;
}

#notificationsModal .list-group {
  max-height: calc(60vh - 100px);
  overflow-y: auto;
}

/* Hover effect untuk notification items */
#notificationsModal .list-group-item-action:hover {
  background-color: rgba(0, 0, 0, 0.05) !important;
}

/* Warning notification background */
.bg-light-warning {
  background-color: rgba(251, 140, 0, 0.1) !important;
}

/* Mobile responsive */
@media (max-width: 768px) {
  #notificationsModal .modal-dialog {
    margin: 0.5rem;
  }
  
  #notificationsModal .modal-body {
    max-height: 70vh;
  }
  
  #notificationsModal .list-group {
    max-height: calc(70vh - 100px);
  }
  
  #notificationsModal .nav-pills .nav-link {
    font-size: 0.75rem;
    padding: 0.5rem 0.25rem;
  }
  
  #notificationsModal .nav-pills .material-symbols-rounded {
    font-size: 1rem;
  }
}
</style>

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
