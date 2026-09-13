<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductItem;
use App\Models\Brand;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'address', 'brand_id'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function productItems()
    {
        return $this->hasMany(ProductItem::class, 'supplier_id');
    }
}


//     public function products()
//     {
//         return $this->hasMany(Product::class);
//     }

//     public function productItems()
// {
//     return $this->hasMany(ProductItem::class, 'supplier_id');
// }

