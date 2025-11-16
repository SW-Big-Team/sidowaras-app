<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranTermin extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'pembayaran_termin';

    /**
     * Atribut yang boleh diisi secara massal.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Relasi many-to-one ke Pembelian.
     * Satu termin dimiliki oleh satu pembelian.
     */
    public function pembelian(): BelongsTo
    {
        return $this->belongsTo(Pembelian::class);
    }

    /**
     * Casts untuk tipe data.
     */
    protected $casts = [
        'tgl_jatuh_tempo' => 'date',
        'tgl_bayar' => 'date',
        'jumlah_bayar' => 'decimal:2',
    ];
}