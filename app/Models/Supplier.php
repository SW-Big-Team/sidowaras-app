<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'supplier';

    protected $fillable = [
        'supplier_name',
        'supplier_phone',
        'supplier_address',
        'supplier_email',
        'supplier_website',
        'supplier_logo',
        'supplier_status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'supplier_status' => 'boolean',
    ];
}


