<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'product_item_id',
        'stock_quantity',
    ];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function productItem()
    {
        return $this->belongsTo(ProductItem::class);
    }
}



//ก่อนใหม่
// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use App\Models\Supplier;
// use Illuminate\Http\Request;

// class Product extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'product_code',
//         'product_item_id',
//         'stock_quantity',
//     ];

//     /**
//      * ความสัมพันธ์กับการเคลื่อนไหวสต็อก
//      */
//     public function stockMovements()
//     {
//         return $this->hasMany(StockMovement::class);
//     }

//     /**
//      * ความสัมพันธ์กับ ProductItem
//      */
//     public function productItem()
//     {
//         return $this->belongsTo(ProductItem::class, 'product_item_id');
//     }

// public function store(Request $request)
// {
//     // 1. สร้าง product_item
//     $item = ProductItem::create([
//         'category_id' => $request->category_id,
//         'brand_id' => $request->brand_id,
//         'supplier_id' => $request->supplier_id,
//         'item_code' => $request->item_code,
//         'item_name' => $request->item_name,
//         'cost_price' => $request->cost_price,
//         'retail_price' => $request->retail_price,
//         'wholesale_price' => $request->wholesale_price,
//         'unit_id' => $request->unit_id,
//         'min_stock' => $request->min_stock,
//     ]);

//     // 🔥 2. สร้าง product (ตัวขายใน POS)
//     Product::create([
//         'product_item_id' => $item->id,
//         'product_code' => 'P' . time(), // หรือ generate เอง
//         'stock_quantity' => $request->stock_quantity,
//     ]);

//     return response()->json([
//         'success' => true,
//         'message' => 'เพิ่มสินค้าและเข้า POS แล้ว'
//     ]);
// }



//     /**
//      * ความสัมพันธ์กับ Category
//      */
//     // public function category()
//     // {
//     //     return $this->belongsTo(Category::class);
//     // }

//     /**
//      * ความสัมพันธ์กับ Brand
//      */
//     // public function brand()
//     // {
//     //     return $this->belongsTo(Brand::class);
//     // }

//     /**
//      * ความสัมพันธ์กับ Supplier
//      */
//     public function supplier()
//     {
//         return $this->belongsTo(Supplier::class);
//     }
// }




//เก่าๆๆ

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use App\Models\ProductItem;




// class Product extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'product_code', 'product_name', 'category_id', 'brand_id', 'supplier_id',
//         'cost_price', 'retail_price', 'wholesale_price', 'color',
//         'stock_unit', 'stock_quantity', 'min_stock'
//     ];
//     protected $fillable = [
//         'product_code',
//         'product_item_id',
//         'stock_quantity',
//     ];




//     public function stockMovements()
//     {
//         return $this->hasMany(StockMovement::class);
//     }


// public function productItem()
// {
//     return $this->belongsTo(ProductItem::class, 'product_item_id');
// }




//     public function category()
//     {
//         return $this->belongsTo(Category::class);
//     }
//     public function brand()
//     {
//         return $this->belongsTo(Brand::class);
//     }
//     public function supplier()
//     {
//         return $this->belongsTo(Supplier::class);
//     }



// }

