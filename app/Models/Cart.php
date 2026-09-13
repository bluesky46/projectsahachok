<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'product_id',
        'unit_price',
        'quantity',
        'total_price',
        'price_type' 
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
