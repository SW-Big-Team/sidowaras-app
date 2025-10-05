<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailStockOpname extends Model
{
    use HasFactory;
    protected $table = 'detail_stock_opname';
    protected $guarded = ['id'];

    public function stockOpname()
    {
        return $this->belongsTo(StockOpname::class, 'opname_id');
    }

    public function batch()
    {
        return $this->belongsTo(StokBatch::class, 'batch_id');
    }
}