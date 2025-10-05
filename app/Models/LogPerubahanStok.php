<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPerubahanStok extends Model
{
    use HasFactory  ;
    protected $table = 'log_perubahan_stok';
    protected $guarded = ['id'];

    public function batch()
    {
        return $this->belongsTo(StokBatch::class, 'batch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}