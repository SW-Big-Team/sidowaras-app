<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->middleware('auth');
        $this->notificationService = $notificationService;
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notif = Notifikasi::findOrFail($id);
        
        // Pastikan user berhak akses notifikasi ini
        $user = Auth::user();
        $role = $user->role->nama_role ?? 'Guest';
        
        if ($notif->user_id == $user->id || $notif->role == $role) {
            $notif->markAsRead();
            
            if ($notif->link) {
                return redirect($notif->link);
            }
        }
        
        return back();
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $role = $user->role->nama_role ?? 'Guest';
        
        $this->notificationService->markAllAsRead($user->id, $role);
        
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }

    /**
     * Get all notifications for current user (API untuk AJAX)
     */
    public function index()
    {
        $user = Auth::user();
        $role = $user->role->nama_role ?? 'Guest';
        
        $notifications = $this->notificationService->getNotificationsForUser($user->id, $role, 50);
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $this->notificationService->getUnreadCount($user->id, $role),
        ]);
    }
}
