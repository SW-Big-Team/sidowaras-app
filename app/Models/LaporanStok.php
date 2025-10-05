<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanStok extends Model
{
    use HasFactory  ;
    protected $table = 'laporan_stok';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return $this->hasMany(LaporanStokDetail::class, 'laporan_id');
    }
}