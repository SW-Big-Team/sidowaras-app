<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';

    // primary key tetap integer auto increment (default)
    protected $fillable = [
        'uuid',
        'no_faktur',
        'nama_pengirim',
        'no_telepon_pengirim',
        'metode_pembayaran',
        'tgl_pembelian',
        'total_harga',
        'user_id',
    ];

    protected $casts = [
        'tgl_pembelian' => 'datetime',
    ];

    /**
     * Gunakan uuid untuk route-model-binding
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stokBatches()
    {
        return $this->hasMany(StokBatch::class, 'pembelian_id', 'id');
    }

    public function pembayaranTermin(): HasMany
    {
        return $this->hasMany(PembayaranTermin::class);
    }
}
