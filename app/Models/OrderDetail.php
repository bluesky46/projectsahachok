<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'orders_id',
        'product_id',
        'quantity',
        'unit_price',
        'price_type',
        'total_price',
        'total_price_with_vat', // เพิ่มตรงนี้
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}

