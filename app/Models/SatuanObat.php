<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanObat extends Model
{
    use HasFactory  ;
    protected $table = 'satuan_obat';
    protected $guarded = ['id'];

    public function obat()
    {
        return $this->hasMany(Obat::class, 'satuan_obat_id');
    }
}