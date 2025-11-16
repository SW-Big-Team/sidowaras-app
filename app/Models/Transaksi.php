<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'uuid',
        'no_transaksi',
        'user_id',
        'total_harga',
        'total_bayar',
        'kembalian',
        'metode_pembayaran',
        'tgl_transaksi',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    protected $casts = [
        'tgl_transaksi' => 'datetime',
    ];
}