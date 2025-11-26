@php
    $items = $items ?? collect();
@endphp

@if($items->count() === 0)
    <div class="text-center py-5">
        <div class="icon icon-shape icon-lg bg-gray-100 text-center border-radius-md mb-3 d-flex align-items-center justify-content-center mx-auto">
            <i class="material-symbols-rounded text-secondary opacity-5 text-3xl">notifications_off</i>
        </div>
        <h6 class="text-secondary mb-0">Tidak ada notifikasi</h6>
        <p class="text-xs text-secondary">Anda sudah membaca semua notifikasi.</p>
    </div>
@else
    <ul class="list-group">
        @foreach($items as $notif)
            @php
                $isWarning = $notif->is_warning ?? false;
                $isUnread = is_null($notif->read_at);
                $iconColor = $notif->icon_color ?? 'success';
            @endphp
            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg {{ $isUnread ? 'bg-white shadow-sm' : '' }}">
                <div class="d-flex flex-column">
                    <h6 class="mb-3 text-sm">
                        {{ $notif->title }}
                        @if($isWarning)
                            <span class="badge badge-sm bg-warning ms-2">Penting</span>
                        @endif
                        @if($isUnread)
                            <span class="badge badge-sm bg-info ms-2">Baru</span>
                        @endif
                    </h6>
                    <span class="mb-2 text-xs">{{ $notif->message }}</span>
                    <span class="text-xs text-secondary font-weight-bold">
                        <i class="material-symbols-rounded align-middle text-xs me-1">schedule</i>
                        {{ optional($notif->created_at)->diffForHumans() }}
                    </span>
                </div>
                <div class="ms-auto text-end">
                    @if($isUnread)
                        <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;" onclick="markAsReadFromModal({{ $notif->id }})">
                            <i class="material-symbols-rounded text-sm me-2">done</i> Tandai Dibaca
                        </a>
                    @endif
                    <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;" onclick="deleteNotification({{ $notif->id }})">
                        <i class="material-symbols-rounded text-sm me-2">delete</i> Hapus
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
@endif
