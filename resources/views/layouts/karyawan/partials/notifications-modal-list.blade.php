@php
    $items = $items ?? collect();
@endphp

@if($items->count() === 0)
  <div class="notif-empty">
    <i class="material-symbols-rounded d-block mb-2" style="font-size: 2.25rem;">notifications_off</i>
    <p class="mb-0 text-sm">Tidak ada notifikasi di bagian ini</p>
  </div>
@else
  <div class="px-1">
    @foreach($items as $notif)
      @php
          $isWarning = $notif->is_warning ?? false;
          $isUnread = is_null($notif->read_at);
          $iconColor = $notif->icon_color ?? 'primary';
      @endphp
      <a
        href="{{ $notif->link ?? '#' }}"
        class="notif-item {{ $isWarning ? 'border-warning bg-warning bg-opacity-10' : '' }} {{ $isUnread ? 'shadow-sm' : '' }}"
        onclick="{{ $isWarning ? 'return true;' : 'markAsReadFromModal(' . $notif->id . '); return true;' }}"
      >
        <div class="notif-icon bg-gradient-{{ $iconColor }} text-white">
          <i class="material-symbols-rounded">{{ $notif->icon ?? 'notifications' }}</i>
        </div>
        <div class="flex-grow-1">
          <div class="d-flex align-items-start justify-content-between">
            <div>
              <div class="d-flex align-items-center gap-2">
                <h6 class="mb-0 fw-semibold">{{ $notif->title }}</h6>
                @if($isWarning)
                  <span class="badge-soft">Penting</span>
                @endif
                @if($isUnread)
                  <span class="badge-soft">Baru</span>
                @endif
              </div>
              <p class="text-sm text-muted mb-1">{{ $notif->message }}</p>
            </div>
            @if($isUnread && !$isWarning)
              <button
                type="button"
                class="btn btn-link text-muted p-0"
                onclick="event.preventDefault(); event.stopPropagation(); markAsReadFromModal({{ $notif->id }});"
                aria-label="Tandai sudah dibaca"
              >
                <i class="material-symbols-rounded">done</i>
              </button>
            @endif
          </div>
          <p class="notif-meta mb-0">
            <i class="material-symbols-rounded align-middle" style="font-size: 0.95rem;">schedule</i>
            {{ optional($notif->created_at)->diffForHumans() }}
          </p>
        </div>
      </a>
    @endforeach
  </div>
@endif
