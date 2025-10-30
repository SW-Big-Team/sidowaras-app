<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StokBatch extends Model
{
    use HasFactory;

    protected $table = 'stok_batch';

    protected $fillable = [
        'uuid',
        'obat_id',
        'pembelian_id',
        'no_batch',
        'barcode',
        'harga_beli',
        'harga_jual',
        'jumlah_masuk',
        'sisa_stok',
        'tgl_kadaluarsa',
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

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'uuid');
    }

    public function logs()
    {
        return $this->hasMany(LogPerubahanStok::class, 'batch_id');
    }
}
