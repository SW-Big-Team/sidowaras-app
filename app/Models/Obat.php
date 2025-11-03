<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

<<<<<<< HEAD
    use HasFactory;

=======
>>>>>>> 3c117fd (Add Cart functionality and update Bootstrap version)
    protected $table = 'obat';
    protected $guarded = ['id'];

    protected $casts = [
        'kandungan_id' => 'array', 
<<<<<<< HEAD
        'kandungan_id' => 'array', 
=======
>>>>>>> 3c117fd (Add Cart functionality and update Bootstrap version)
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriObat::class, 'kategori_id');
    }

    public function satuan()
    {
        return $this->belongsTo(SatuanObat::class, 'satuan_obat_id');
    }

    // Relasi ke batch stok
<<<<<<< HEAD
    // Relasi ke batch stok
=======
>>>>>>> 3c117fd (Add Cart functionality and update Bootstrap version)
    public function stokBatches()
    {
        return $this->hasMany(StokBatch::class);
    }

    /**
     * Accessor: Mengembalikan koleksi kandungan terkait.
<<<<<<< HEAD
<<<<<<< HEAD
     * $obat->kandungan
     */
    public function getkandunganAttribute()
=======
     * $obat->kandungans
     */
    public function getKandungansAttribute()
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
=======
     * $obat->kandungan
     */
    public function getkandunganAttribute()
>>>>>>> e04ebff (Add new views and controllers for Stok and Transaksi management, update relationships in models, and enhance kategori forms.)
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
<<<<<<< HEAD
<<<<<<< HEAD
        return $this->kandungan->flatMap(function ($k) {
=======
        return $this->kandungans->flatMap(function ($k) {
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
=======
        return $this->kandungan->flatMap(function ($k) {
>>>>>>> e04ebff (Add new views and controllers for Stok and Transaksi management, update relationships in models, and enhance kategori forms.)
            return $k->nama_kandungan ?? [];
        })->values();
    }
    public function getStokTersediaAttribute()
{
    return $this->stokBatches()->where('sisa_stok', '>', 0)->sum('sisa_stok');
}
}