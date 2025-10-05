<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory  ;
    protected $table = 'stock_opname';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return $this->hasMany(DetailStockOpname::class, 'opname_id');
    }
}