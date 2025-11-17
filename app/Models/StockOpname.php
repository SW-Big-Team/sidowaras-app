<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;
    protected $table = 'stock_opname';
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'approved_at' => 'datetime',
        ];
    }

    public function details()
    {
        return $this->hasMany(DetailStockOpname::class, 'stock_opname_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    
    // Helper methods
    public function getTotalItemsAttribute()
    {
        return $this->details()->count();
    }
    
    public function getTotalVarianceAttribute()
    {
        return $this->details()->get()->sum(function($detail) {
            return abs($detail->physical_qty - $detail->system_qty);
        });
    }
    
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'bg-secondary',
            'pending' => 'bg-warning',
            'approved' => 'bg-success',
            'rejected' => 'bg-danger',
        ];
        return $badges[$this->status] ?? 'bg-secondary';
    }
}