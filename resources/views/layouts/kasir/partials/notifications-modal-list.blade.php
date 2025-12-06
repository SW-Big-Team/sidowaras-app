@php
    $items = $items ?? collect();
@endphp

@if($items->count() === 0)
    <div class="notif-empty">
        <div class="empty-icon"><i class="material-symbols-rounded">notifications_off</i></div>
        <h6>Tidak ada notifikasi</h6>
        <p>Anda sudah membaca semua notifikasi.</p>
    </div>
@else
    <div class="notif-list">
        @foreach($items as $notif)
            @php
                $isWarning = $notif->is_warning ?? false;
                $isUnread = is_null($notif->read_at);
                $iconColor = $isWarning ? 'warning' : ($isUnread ? 'primary' : 'secondary');
            @endphp
            <div class="notif-item {{ $isUnread ? 'unread' : '' }} {{ $isWarning ? 'warning' : '' }}">
                <div class="notif-icon {{ $iconColor }}">
                    <i class="material-symbols-rounded">{{ $isWarning ? 'warning' : 'notifications' }}</i>
                </div>
                <div class="notif-content">
                    <h6 class="notif-title">{{ $notif->title }}</h6>
                    <p class="notif-message">{{ $notif->message }}</p>
                    <span class="notif-time"><i class="material-symbols-rounded">schedule</i> {{ optional($notif->created_at)->diffForHumans() }}</span>
                </div>
                <div class="notif-actions">
                    @if($isUnread)
                        <button class="action-btn read" onclick="markAsReadFromModal({{ $notif->id }})" title="Tandai Dibaca">
                            <i class="material-symbols-rounded">done</i>
                        </button>
                    @endif
                    <button class="action-btn delete" onclick="deleteNotification({{ $notif->id }})" title="Hapus">
                        <i class="material-symbols-rounded">delete</i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endif

<style>
.notif-empty { text-align: center; padding: 3rem 1rem; color: #64748b; }
.empty-icon { width: 64px; height: 64px; background: #f1f5f9; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
.empty-icon i { font-size: 32px; color: #94a3b8; }
.notif-empty h6 { font-size: 0.95rem; color: #475569; margin-bottom: 4px; }
.notif-empty p { font-size: 0.8rem; margin: 0; }
.notif-list { display: flex; flex-direction: column; gap: 10px; }
.notif-item { display: flex; align-items: flex-start; gap: 12px; padding: 1rem; background: #f8fafc; border-radius: 12px; border: 1px solid transparent; transition: all 0.2s; }
.notif-item:hover { border-color: #e2e8f0; }
.notif-item.unread { background: white; border-color: #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
.notif-item.warning { border-left: 3px solid #f59e0b; }
.notif-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.notif-icon.primary { background: rgba(59,130,246,0.1); color: #3b82f6; }
.notif-icon.warning { background: rgba(245,158,11,0.1); color: #f59e0b; }
.notif-icon.secondary { background: #f1f5f9; color: #94a3b8; }
.notif-icon i { font-size: 20px; }
.notif-content { flex: 1; min-width: 0; }
.notif-title { font-size: 0.85rem; font-weight: 600; color: #1e293b; margin: 0 0 4px; }
.notif-message { font-size: 0.8rem; color: #64748b; margin: 0 0 8px; line-height: 1.4; }
.notif-time { display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; color: #94a3b8; }
.notif-time i { font-size: 14px; }
.notif-actions { display: flex; gap: 6px; flex-shrink: 0; }
.action-btn { width: 32px; height: 32px; border-radius: 8px; border: none; background: transparent; color: #64748b; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
.action-btn i { font-size: 18px; }
.action-btn.read:hover { background: rgba(16,185,129,0.1); color: #10b981; }
.action-btn.delete:hover { background: rgba(239,68,68,0.1); color: #ef4444; }
</style>
