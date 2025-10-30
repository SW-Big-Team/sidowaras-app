<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'obat_id',
        'jumlah',
        'harga_satuan',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
