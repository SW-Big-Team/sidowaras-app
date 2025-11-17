<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailStockOpname extends Model
{
    use HasFactory;
    protected $table = 'detail_stock_opname';
    protected $guarded = ['id'];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }

    public function stockOpname()
    {
        return $this->belongsTo(StockOpname::class, 'stock_opname_id');
    }
}