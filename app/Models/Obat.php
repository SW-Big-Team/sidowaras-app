<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory  ;
    protected $table = 'obat';
    protected $guarded = ['id'];

    protected $casts = [
        'kandungan_id' => 'array',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriObat::class, 'kategori_id');
    }

    public function satuan()
    {
        return $this->belongsTo(SatuanObat::class, 'satuan_obat_id');
    }

    public function kandungan()
    {
        return KandunganObat::whereIn('id', $this->kandungan_id ?? [])->get();
    }

    public function stokBatches()
    {
        return $this->hasMany(StokBatch::class);
    }
}