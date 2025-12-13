<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Log extends Model
{
    protected $table = 'logs';
    
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'ip_address',
        'user_agent',
        'request_data',
        'response_data',
        'status',
        'error_message',
        'route',
        'method',
    ];
    
    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get the user that performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the model that was affected
     */
    public function model(): MorphTo
    {
        return $this->morphTo('model', 'model_type', 'model_id');
    }
    
    /**
     * Scope to filter by action
     */
    public function scopeAction($query, string $action)
    {
        return $query->where('action', $action);
    }
    
    /**
     * Scope to filter by status
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
    
    /**
     * Scope to filter by user
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
    
    /**
     * Scope to filter by model
     */
    public function scopeForModel($query, string $modelType, ?int $modelId = null)
    {
        $query->where('model_type', $modelType);
        
        if ($modelId !== null) {
            $query->where('model_id', $modelId);
        }
        
        return $query;
    }
    
    /**
     * Scope to filter by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
    
    /**
     * Scope to get recent logs
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
