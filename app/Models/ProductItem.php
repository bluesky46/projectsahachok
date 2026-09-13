<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_code',
        'item_name',
        'category_id',
        'brand_id',
        'supplier_id',
        'cost_price',
        'retail_price',
        'wholesale_price',
        'unit_id',
        'min_stock',
        'stock_quantity',
    ];

    // ความสัมพันธ์
    public function category() { return $this->belongsTo(Category::class); }
    public function brand() { return $this->belongsTo(Brand::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function products() { return $this->hasMany(Product::class); }
    public function unit()  {  return $this->belongsTo(Unit::class); }


    public function stockMovements()
{
    return $this->hasMany(StockMovement::class, 'product_item_id');
}


public function latestReceivedDate()
{
    return $this->stockMovements()
                ->where('type', 'in') // สมมติว่า type = 'in' คือรับสินค้าเข้าสต็อก
                ->latest('date')      // เรียงจากวันที่ล่าสุด
                ->first();
}



// public function coilstocks()
// {
//     return $this->hasMany(Coilstock::class, 'product_item_id');
// }


}
