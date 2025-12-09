<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';
    protected $guarded = ['id'];

    protected $casts = [
        'kandungan_id' => 'array',
        'satuan_obat_id' => 'array',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriObat::class, 'kategori_id');
    }

    public function getsatuanAttribute()
    {
        if (empty($this->satuan_obat_id) || !is_array($this->satuan_obat_id)) {
            return collect();
        }

        return SatuanObat::whereIn('id', $this->satuan_obat_id)->get();
    }

    // Relasi ke batch stok
    public function stokBatches()
    {
        return $this->hasMany(StokBatch::class, 'obat_id');
    }

    /**
     * Accessor: Mengembalikan koleksi kandungan terkait.
     * $obat->kandungan
     */
    public function getkandunganAttribute()
    {
        if (empty($this->kandungan_id) || !is_array($this->kandungan_id)) {
            return collect();
        }

        return KandunganObat::whereIn('id', $this->kandungan_id)->get();
    }

    /**
     * Helper: Ambil semua nama kandungan sebagai flat array string.
     */
    public function getDaftarKandunganAttribute()
    {
        return $this->kandungan->flatMap(function ($k) {
            return $k->nama_kandungan ?? [];
        })->values();
    }
    public function getStokTersediaAttribute()
    {
        return $this->stokBatches()->where('sisa_stok', '>', 0)->sum('sisa_stok');
    }
}