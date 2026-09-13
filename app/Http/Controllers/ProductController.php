<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller

{

// public function index()
// {
//     $products = Product::all(); // ดึงข้อมูลสินค้าทั้งหมด
//     return view('productlist', compact('products'));
// }

//     public function home()
//     {
//         $products = Product::all();
//         return view('home', compact('products'));
//     }


//     public function productList()
//     {
//         $categories = Category::all();
//         $brands = Brand::all();
//         $suppliers = Supplier::all();

//         // ดึงสินค้าที่พร้อมขาย พร้อม relation ผ่าน productItem
//         $readyProducts = Product::with([
//             'productItem.category',
//             'productItem.brand',
//             'productItem.supplier'
//         ])->get();

//         return view('productlist', compact('categories', 'brands', 'suppliers', 'readyProducts'));
//     }

// public function removeFromPOS($id)
// {
//     $product = Product::findOrFail($id);
//     $product->delete();
//     return redirect()->back()->with('success', 'ลบสินค้าเรียบร้อยแล้ว');
// }



//     // Get ProductItem via AJAX (filter by category/brand/supplier)
//     public function getProducts(Request $request)
//     {
//         $query = ProductItem::query()->with(['category', 'brand', 'supplier']);
//         if ($request->category_id) $query->where('category_id', $request->category_id);
//         if ($request->brand_id) $query->where('brand_id', $request->brand_id);
//         if ($request->supplier_id) $query->where('supplier_id', $request->supplier_id);

//         return response()->json($query->get());
//     }

//     // ดึง Brand ตาม Category
// public function getBrandsByCategory($category_id)
// {
//     $brands = Brand::where('category_id', $category_id)->get();
//     return response()->json($brands);
// }

// // ดึง Supplier ตาม Category + Brand
// public function getSuppliersByCategoryBrand(Request $request)
// {
//     $suppliers = Supplier::whereHas('products', function($q) use ($request) {
//         if ($request->category_id) $q->where('category_id', $request->category_id);
//         if ($request->brand_id) $q->where('brand_id', $request->brand_id);
//     })->get();
//     return response()->json($suppliers);
// }

// // ดึง Product ตาม Category + Brand + Supplier
// public function getProductsFiltered(Request $request)
// {
//     $query = ProductItem::query()->with(['category','brand','supplier']);

//     if ($request->category_id) $query->where('category_id', $request->category_id);
//     if ($request->brand_id) $query->where('brand_id', $request->brand_id);
//     if ($request->supplier_id) $query->where('supplier_id', $request->supplier_id);

//     return response()->json($query->get());
// }

// public function destroy($id)
// {
//     $product = Product::findOrFail($id);
//     $product->delete();

//     return response()->json([
//         'success' => true,
//         'message' => 'ลบสินค้าสำเร็จ'
//     ]);
// }


// public function edit(Product $product)
// {
//     return response()->json([
//         'success' => true,
//         'product' => $product
//     ]);
// }

// public function update(Request $request, Product $product)
// {
//     $product->update($request->only([
//         'item_name','cost_price','retail_price','wholesale_price',
//         'stock_unit','min_stock','category_id','brand_id','supplier_id'
//     ]));

//     $html = view('partials.product-row', compact('product'))->render();

//     return response()->json([
//         'success' => true,
//         'html' => $html,
//         'product_id' => $product->id
//     ]);
// }


// public function allProducts()
// {
//     $imported = Product::pluck('product_item_id');

//     $items = ProductItem::with(['category','brand','supplier'])
//         ->whereNotIn('id', $imported)
//         ->orderBy('item_name')
//         ->get();

//     return response()->json($items);
// }
// public function importToPOS(Request $request)
// {
//     foreach($request->product_ids as $id){

//         if(Product::where('product_item_id',$id)->exists()){
//             continue;
//         }

//         $item = ProductItem::find($id);

//         Product::create([
//             'product_item_id' => $item->id,
//             'product_code' => $item->item_code,
//             'stock_quantity'  => $item->stock_quantity

//         ]);
//     }

//     return response()->json(['success'=>true]);
// }




}

