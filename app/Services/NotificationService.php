<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\Obat;
use App\Models\StokBatch;
use App\Models\StockOpname;
use App\Models\Pembelian;
use Carbon\Carbon;

class NotificationService
{
    /**
     * Generate notifikasi untuk stok obat yang menipis
     */
    public function checkStokMenipis()
    {
        $obatMenipis = Obat::withSum('stokBatches as total_stok', 'sisa_stok')
            ->whereRaw('COALESCE((SELECT SUM(sisa_stok) FROM stok_batch WHERE stok_batch.obat_id = obat.id), 0) <= stok_minimum')
            ->get();

        // Hapus notifikasi stok menipis lama untuk role Admin & Karyawan
        Notifikasi::where('type', 'stok_menipis')
            ->where('is_warning', true)
            ->whereIn('role', ['Admin', 'Karyawan'])
            ->delete();

        if ($obatMenipis->count() > 0) {
            foreach (['Admin', 'Karyawan'] as $role) {
                Notifikasi::create([
                    'role' => $role,
                    'type' => 'stok_menipis',
                    'is_warning' => true, // Warning persistent
                    'title' => 'Stok Menipis',
                    'message' => $obatMenipis->count() . ' obat perlu restok segera',
                    'icon' => 'inventory_2',
                    'icon_color' => 'warning',
                    'link' => route('stok.index'),
                ]);
            }
        }
    }

    /**
     * Generate notifikasi untuk obat yang akan kadaluarsa
     */
    public function checkObatKadaluarsa()
    {
        $tglBatas = Carbon::now()->addMonth();
        
        $batchKadaluarsa = StokBatch::where('tgl_kadaluarsa', '<=', $tglBatas)
            ->where('tgl_kadaluarsa', '>=', Carbon::now())
            ->where('sisa_stok', '>', 0)
            ->count();

        // Hapus notifikasi kadaluarsa lama
        Notifikasi::where('type', 'obat_kadaluarsa')
            ->where('is_warning', true)
            ->whereIn('role', ['Admin', 'Karyawan'])
            ->delete();

        if ($batchKadaluarsa > 0) {
            foreach (['Admin', 'Karyawan'] as $role) {
                Notifikasi::create([
                    'role' => $role,
                    'type' => 'obat_kadaluarsa',
                    'is_warning' => true, // Warning persistent
                    'title' => 'Obat Kadaluarsa',
                    'message' => $batchKadaluarsa . ' batch akan kadaluarsa bulan ini',
                    'icon' => 'event_busy',
                    'icon_color' => 'danger',
                    'link' => route('stok.index'),
                ]);
            }
        }
    }

    /**
     * Generate notifikasi untuk stock opname pending (Admin only)
     */
    public function checkStockOpnamePending()
    {
        $pendingCount = StockOpname::where('status', 'pending')->count();

        // Hapus notifikasi pending lama
        Notifikasi::where('type', 'stock_opname_pending')
            ->where('is_warning', true)
            ->where('role', 'Admin')
            ->delete();

        if ($pendingCount > 0) {
            Notifikasi::create([
                'role' => 'Admin',
                'type' => 'stock_opname_pending',
                'is_warning' => true, // Warning persistent
                'title' => 'Stock Opname Menunggu',
                'message' => $pendingCount . ' stock opname menunggu approval',
                'icon' => 'pending_actions',
                'icon_color' => 'warning',
                'link' => route('admin.stokopname.pending'),
            ]);
        }
    }

    /**
     * Notifikasi ketika pembelian baru dibuat
     */
    public function notifyPembelianBaru(Pembelian $pembelian)
    {
        // Notifikasi untuk semua role (event notification - bisa ditandai dibaca)
        foreach (['Admin', 'Karyawan', 'Kasir'] as $role) {
            Notifikasi::create([
                'role' => $role,
                'type' => 'pembelian_baru',
                'is_warning' => false, // Event notification
                'title' => 'Pembelian Baru',
                'message' => 'Pembelian ' . $pembelian->no_faktur . ' berhasil disimpan',
                'icon' => 'shopping_cart',
                'icon_color' => 'success',
                'link' => route('pembelian.show', $pembelian->uuid),
            ]);
        }
    }

    /**
     * Notifikasi ketika stock opname dibuat (untuk Admin)
     */
    public function notifyStockOpnameCreated(StockOpname $opname)
    {
        Notifikasi::create([
            'role' => 'Admin',
            'type' => 'stock_opname_created',
            'is_warning' => false, // Event notification
            'title' => 'Stock Opname Baru',
            'message' => 'Stock opname ' . Carbon::parse($opname->tanggal)->format('d/m/Y') . ' menunggu approval',
            'icon' => 'pending_actions',
            'icon_color' => 'warning',
            'link' => route('stokopname.show', $opname->id),
        ]);
    }

    /**
     * Notifikasi ketika stock opname disetujui (untuk creator)
     */
    public function notifyStockOpnameApproved(StockOpname $opname)
    {
        Notifikasi::create([
            'user_id' => $opname->created_by,
            'type' => 'stock_opname_approved',
            'is_warning' => false, // Event notification
            'title' => 'Stock Opname Disetujui',
            'message' => 'Stock opname ' . Carbon::parse($opname->tanggal)->format('d/m/Y') . ' telah disetujui',
            'icon' => 'check_circle',
            'icon_color' => 'success',
            'link' => route('stokopname.show', $opname->id),
        ]);
    }

    /**
     * Notifikasi ketika stock opname ditolak (untuk creator)
     */
    public function notifyStockOpnameRejected(StockOpname $opname)
    {
        Notifikasi::create([
            'user_id' => $opname->created_by,
            'type' => 'stock_opname_rejected',
            'is_warning' => false, // Event notification
            'title' => 'Stock Opname Ditolak',
            'message' => 'Stock opname ' . Carbon::parse($opname->tanggal)->format('d/m/Y') . ' ditolak',
            'icon' => 'cancel',
            'icon_color' => 'danger',
            'link' => route('stokopname.show', $opname->id),
        ]);
    }

    /**
     * Generate semua notifikasi sistem
     */
    public function generateSystemNotifications()
    {
        $this->checkStokMenipis();
        $this->checkObatKadaluarsa();
        $this->checkStockOpnamePending();
        $this->checkCartPendingApproval();
        $this->checkStockOpnameReminderForKaryawan();
    }

    /**
     * Check cart yang menunggu approval (untuk Kasir)
     */
    public function checkCartPendingApproval()
    {
        $pendingCount = \App\Models\Cart::where('is_approved', false)->count();

        // Hapus notifikasi cart pending lama
        Notifikasi::where('type', 'cart_pending_approval')
            ->where('is_warning', true)
            ->where('role', 'Kasir')
            ->delete();

        if ($pendingCount > 0) {
            Notifikasi::create([
                'role' => 'Kasir',
                'type' => 'cart_pending_approval',
                'is_warning' => true, // Warning persistent
                'title' => 'Cart Menunggu Approval',
                'message' => $pendingCount . ' cart menunggu diproses',
                'icon' => 'shopping_cart_checkout',
                'icon_color' => 'warning',
                'link' => route('kasir.cart.approval'),
            ]);
        }
    }

    /**
     * Check apakah karyawan sudah generate stock opname hari ini
     */
    public function checkStockOpnameReminderForKaryawan()
    {
        $today = Carbon::today();
        $hasOpnameToday = StockOpname::whereDate('created_at', $today)->exists();

        // Hapus notifikasi reminder lama
        Notifikasi::where('type', 'stock_opname_reminder')
            ->where('is_warning', true)
            ->where('role', 'Karyawan')
            ->delete();

        if (!$hasOpnameToday) {
            Notifikasi::create([
                'role' => 'Karyawan',
                'type' => 'stock_opname_reminder',
                'is_warning' => true, // Warning persistent
                'title' => 'Stock Opname Hari Ini',
                'message' => 'Belum ada stock opname untuk hari ini',
                'icon' => 'assignment',
                'icon_color' => 'info',
                'link' => route('stokopname.create'),
            ]);
        }
    }

    /**
     * Notifikasi ketika cart diapprove (untuk creator)
     */
    public function notifyCartApproved(\App\Models\Cart $cart)
    {
        Notifikasi::create([
            'user_id' => $cart->user_id,
            'type' => 'cart_approved',
            'is_warning' => false, // Event notification
            'title' => 'Cart Disetujui',
            'message' => 'Cart Anda telah diproses menjadi transaksi',
            'icon' => 'check_circle',
            'icon_color' => 'success',
            'link' => route('kasir.transaksi.riwayat'),
        ]);
    }

    /**
     * Notifikasi ketika cart ditolak (untuk creator)
     */
    public function notifyCartRejected(\App\Models\Cart $cart)
    {
        Notifikasi::create([
            'user_id' => $cart->user_id,
            'type' => 'cart_rejected',
            'is_warning' => false, // Event notification
            'title' => 'Cart Ditolak',
            'message' => 'Cart Anda telah ditolak oleh kasir',
            'icon' => 'cancel',
            'icon_color' => 'danger',
            'link' => '#',
        ]);
    }

    /**
     * Get notifikasi untuk user tertentu (warning + unread events)
     */
    public function getNotificationsForUser($userId, $role, $limit = 10)
    {
        return Notifikasi::forUser($userId, $role)
            ->where(function($q) {
                // Warning (selalu muncul) ATAU Event yang belum dibaca
                $q->where('is_warning', true)
                  ->orWhere(function($sub) {
                      $sub->where('is_warning', false)->where('is_read', false);
                  });
            })
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get jumlah notifikasi yang belum dibaca (warning + unread events)
     */
    public function getUnreadCount($userId, $role)
    {
        return Notifikasi::forUser($userId, $role)
            ->where(function($q) {
                // Warning (selalu muncul) ATAU Event yang belum dibaca
                $q->where('is_warning', true)
                  ->orWhere(function($sub) {
                      $sub->where('is_warning', false)->where('is_read', false);
                  });
            })
            ->count();
    }

    /**
     * Tandai semua notifikasi EVENT user sebagai dibaca (tidak affect warning)
     */
    public function markAllAsRead($userId, $role)
    {
        Notifikasi::forUser($userId, $role)
            ->where('is_warning', false) // Hanya event notifications
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }
}
