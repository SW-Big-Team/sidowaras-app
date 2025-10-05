<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepRacikan extends Model
{
    use HasFactory  ;
    protected $table = 'resep_racikan';
    protected $guarded = ['id'];

    public function obatRacikan()
    {
        return $this->belongsTo(Obat::class, 'obat_racikan_id');
    }

    public function obatKomponen()
    {
        return $this->belongsTo(Obat::class, 'obat_komponen_id');
    }
}