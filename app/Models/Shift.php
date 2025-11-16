<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table = 'shift';

    protected $fillable = [
        'shift_name',
        'shift_day_of_week',
        'shift_start',
        'shift_end',
        'shift_status',
        'user_list'
    ];

    protected $casts = [
        'shift_status' => 'boolean',
        'user_list' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get users from user_list IDs
     */
    public function getUsersAttribute()
    {
        if (empty($this->user_list)) {
            return collect();
        }
        
        return User::whereIn('id', $this->user_list)->get();
    }
}
