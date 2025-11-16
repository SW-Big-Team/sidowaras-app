<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LogPerubahanStok extends Model
{
    use HasFactory;

    protected $table = 'log_perubahan_stok';

    protected $fillable = [
        'uuid',
        'batch_id',
        'user_id',
        'stok_sebelum',
        'stok_sesudah',
        'keterangan',
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

    public function batch()
    {
        return $this->belongsTo(StokBatch::class, 'batch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
