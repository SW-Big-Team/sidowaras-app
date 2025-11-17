<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    
    protected $fillable = [
        'uuid',
        'user_id',
        'role',
        'type',
        'is_warning',
        'title',
        'message',
        'icon',
        'icon_color',
        'link',
        'is_read',
        'read_at',
    ];
    
    protected $casts = [
        'is_warning' => 'boolean',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
    
    public function scopeWarnings($query)
    {
        return $query->where('is_warning', true);
    }
    
    public function scopeEvents($query)
    {
        return $query->where('is_warning', false);
    }
    
    public function scopeForUser($query, $userId, $role)
    {
        return $query->where(function($q) use ($userId, $role) {
            $q->where('user_id', $userId)
              ->orWhere('role', $role);
        });
    }
    
    public function markAsRead()
    {
        // Hanya event notification yang bisa ditandai dibaca
        if (!$this->is_warning) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }
}
