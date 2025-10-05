<?php

namespace App\Models;

use App\Enums\MetodePembayaran;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pembelian';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'metode_pembayaran' => MetodePembayaran::class,
            'tgl_pembelian' => 'datetime',
        ];
    }

    /**
     * Get the user that recorded the purchase.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the stock batches associated with this purchase.
     */
    public function stokBatches()
    {
        return $this->hasMany(StokBatch::class, 'pembelian_id', 'uuid');
    }
}
