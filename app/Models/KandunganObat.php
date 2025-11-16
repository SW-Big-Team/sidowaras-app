<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KandunganObat extends Model
{
    use HasFactory;
    
    protected $table = 'kandungan_obat';
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['nama_kandungan' => 'array'];
    }

    public function getNamaKandunganTextAttribute()
    {
        if (is_array($this->nama_kandungan)) {
            return implode(', ', $this->nama_kandungan);
        }
        return $this->nama_kandungan;
    }

    /**
     * Accessor: Mengembalikan label lengkap dengan dosis
     */
    public function getLabelLengkapAttribute()
    {
        return $this->nama_kandungan_text . ' (' . $this->dosis_kandungan . ')';
    }

    public function obat()
    {
        return $this->hasMany(Obat::class, 'kandungan_id');
    }
}