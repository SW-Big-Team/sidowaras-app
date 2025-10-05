<?php

namespace App\Models;

use App\Enums\MetodePembayaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaksi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'transaksi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'metode_pembayaran' => MetodePembayaran::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}

