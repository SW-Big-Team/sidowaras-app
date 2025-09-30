<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KandunganObat extends Model
{
    use HasFactory  ;
    protected $table = 'kandungan_obat';
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['nama_kandungan' => 'array'];
    }

    public function obat()
    {
        return $this->hasMany(Obat::class, 'kandungan_id');
    }
}