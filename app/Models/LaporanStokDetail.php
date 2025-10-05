<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanStokDetail extends Model
{
    use HasFactory  ;
    protected $table = 'laporan_stok_detail';
    protected $guarded = ['id'];

    public function laporanStok()
    {
        return $this->belongsTo(LaporanStok::class, 'laporan_id');
    }
}