<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductItem;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use App\Models\Supplier;

class ProductController extends Controller
{

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'product_code' => 'required|unique:products,product_code',
    //         'product_name' => 'required',
    //         'category' => 'required',
    //         'group' => 'required',
    //         'color' => 'nullable',
    //         'brand' => 'nullable',
    //         'seller' => 'nullable',
    //         'retail_price' => 'nullable|numeric',
    //         'wholesale_price' => 'nullable|numeric',
    //         'stock_unit' => 'required|string',
    //         'sales_unit' => 'required',
    //         'min_stock' => 'nullable|numeric',
    //     ]);

    //     // สร้างสินค้าใหม่
    //     $product = Product::create($request->all());

    //     // บันทึกการเคลื่อนไหวสต็อก (ถ้ามี min_stock)
    //     if (!empty($request->min_stock) && $request->min_stock > 0) {
    //         StockMovement::create([
    //             'product_id' => $product->id,
    //             'quantity' => $request->min_stock,
    //             'movement_type' => 'เพิ่มสินค้าใหม่',
    //             'note' => 'เพิ่มสินค้าพร้อมสต็อกเริ่มต้น',
    //         ]);
    //     }

    //     return redirect()->route('product.list')->with('success', 'Product added successfully!');
    // }

    // public function update(Request $request, $id)
    // {
    //     $product = Product::findOrFail($id);

    //     $request->validate([
    //         'product_code' => 'required',
    //         'product_name' => 'required',
    //         'category' => 'required',
    //         'group' => 'required',
    //         'color' => 'nullable',
    //         'brand' => 'nullable',
    //         'seller' => 'nullable',
    //         'retail_price' => 'nullable|numeric',
    //         'wholesale_price' => 'nullable|numeric',
    //         'stock_unit' => 'required|string',
    //         'sales_unit' => 'required',
    //         'min_stock' => 'nullable|numeric',
    //     ]);

    //     $product->update($request->all());

    //     return redirect()->route('product.list')->with('success', 'Product updated successfully');
    // }
    // public function destroy($id)
    // {
    //     $product = Product::find($id);
    //     if (!$product) {
    //         return redirect()->route('product.list')->with('error', 'Product not found!');
    //     }

    //     // บันทึกการเคลื่อนไหวก่อนลบสินค้า
    //     StockMovement::create([
    //         'product_id' => $product->id,
    //         'quantity' => 0,
    //         'movement_type' => 'ลบสินค้า',
    //         'note' => 'ลบสินค้ารหัส ' . $product->product_code . ' ชื่อ ' . $product->product_name,
    //     ]);


    //     $product->delete();

    //     return redirect()->route('product.list')->with('success', 'Product deleted successfully!');
    // }



    // public function saveSelection(Request $request)
    // {
    //     $selectedProducts = json_decode($request->input('selected_products'), true);
    //     return redirect()->route('product.list')->with('success', 'Your selection has been saved!');
    // }

    // public function add()
    // {
    //     return view('add');
    // }

    // หน้าการจัดการสินค้า






    // บันทึกสินค้าใหม่
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'product_code' => 'required|unique:products',
    //         'product_name' => 'required',
    //         'category_id' => 'required',
    //         'brand_id' => 'required',
    //         'cost_price' => 'required|numeric',
    //         'stock_unit' => 'required'
    //     ]);

    //     Product::create($request->all());

    //     return redirect()->back()->with('success', 'เพิ่มสินค้าสำเร็จ');
    // }
    // public function store(Request $request)
    // {
    //     // สร้างหรือใช้ Category ที่มีอยู่
    //     $category = Category::firstOrCreate(['name' => $request->category_name]);

    //     // สร้างหรือใช้ Brand ที่มีอยู่ และผูกกับ Category
    //     $brand = Brand::firstOrCreate([
    //         'name' => $request->brand_name,
    //         'category_id' => $category->id
    //     ]);

    //     // สร้างหรือใช้ Supplier ที่มีอยู่
    //     $supplier = null;
    //     if ($request->supplier_name) {
    //         $supplier = Supplier::firstOrCreate(['name' => $request->supplier_name]);
    //     }

    //     // สร้าง Product
    //     Product::create([
    //         'product_code' => $request->product_code,
    //         'product_name' => $request->product_name,
    //         'category_id' => $category->id,
    //         'brand_id' => $brand->id,
    //         'supplier_id' => $supplier?->id,
    //         'cost_price' => $request->cost_price,
    //         'retail_price' => $request->retail_price,
    //         'wholesale_price' => $request->wholesale_price,
    //         'stock_unit' => $request->stock_unit,
    //         'stock_quantity' => $request->stock_quantity,
    //     ]);

    //     return redirect()->route('products.list')->with('success', 'บันทึกสินค้าเรียบร้อยแล้ว');
    // }

    // หน้าแสดงรายการสินค้า (สำหรับเลือกใน POS)
    // public function productList(Request $request)
    // {
    //     $categories = Category::all();
    //     $brands = Brand::all();
    //     $suppliers = Supplier::all();

    //     $query = Product::query();

    //     if ($request->category_id) {
    //         $query->where('category_id', $request->category_id);
    //     }
    //     if ($request->brand_id) {
    //         $query->where('brand_id', $request->brand_id);
    //     }

    //     $products = $query->get();
    //     return view('productlist', compact('products', 'categories', 'brands', 'suppliers'));
    // }




    // เก่า
//     public function store(Request $request)
// {
//     $request->validate([
//         'product_name' => 'required',
//         'category_name' => 'required',
//         'brand_name' => 'required',
//         'cost_price' => 'required|numeric',
//         'stock_unit' => 'required'
//     ]);

//     // สร้าง Category
//     $category = Category::firstOrCreate(['name' => $request->category_name]);

//     // สร้าง Brand
//     $brand = Brand::firstOrCreate([
//         'name' => $request->brand_name,
//         'category_id' => $category->id
//     ]);

//     // สร้าง Supplier
//     $supplier = $request->supplier_name ? Supplier::firstOrCreate(['name' => $request->supplier_name]) : null;

//     // สร้าง Product
//     $product = Product::create([
//         'product_code' => $request->product_code,
//         'product_name' => $request->product_name,
//         'category_id' => $category->id,
//         'brand_id' => $brand->id,
//         'supplier_id' => $supplier?->id,
//         'cost_price' => $request->cost_price,
//         'retail_price' => $request->retail_price,
//         'wholesale_price' => $request->wholesale_price,
//         'stock_unit' => $request->stock_unit,
//         'stock_quantity' => $request->stock_quantity,
//     ]);

//     return redirect()->back()->with('success', 'บันทึกสินค้าเรียบร้อย!');
// }

//     public function productList(Request $request)
// {
//     $categories = Category::all();
//     $suppliers = Supplier::all();

//     $products = Product::with(['category', 'brand', 'supplier'])->get();

//     return view('productlist', compact('products', 'categories', 'suppliers'));
// }


// public function add()
// {
//     $categories = Category::all();
//     $brands = Brand::all();
//     $suppliers = Supplier::all();

//     $productCode = $this->generateProductCode(); // เรียก generate รหัส

//     return view('add', compact('categories','brands','suppliers','productCode'));
// }



// public function generateProductCode()
// {
//     $last = Product::latest('id')->first();
//     $number = $last ? $last->id + 1 : 1;
//     return 'P' . str_pad($number, 5, '0', STR_PAD_LEFT); // P00001, P00002...
// }

// public function add()
// {
// $categories = Category::all();
// $brands = Brand::all();
// $suppliers = Supplier::all();
// $productCode = $this->generateProductCode();

// return view('add', compact('categories','brands','suppliers','productCode'));
// }

// public function store(Request $request)
// {
//     // บันทึก Category
//     $category = Category::firstOrCreate(['name' => $request->category_name]);

//     // บันทึก Brand
//     $brand = Brand::firstOrCreate(
//         ['name' => $request->brand_name, 'category_id' => $category->id]
//     );

//     // บันทึก Supplier (ถ้ามี)
//     $supplier = null;
//     if($request->supplier_name){
//         $supplier = Supplier::firstOrCreate(['name' => $request->supplier_name]);
//     }

//     return response()->json([
//         'message' => 'บันทึกสำเร็จ',
//         'category_id' => $category->id,
//         'brand_id' => $brand->id,
//         'supplier_id' => $supplier ? $supplier->id : null
//     ]);
// }

// public function storeCategory(Request $request)
// {
//     $data = $request->all(); // Laravel จะจับค่าจาก JSON ได้
//     $request->validate([
//         'category_name' => 'required',
//         'brand_name' => 'required',
//         'supplier_name' => 'nullable'
//     ]);

//     $category = Category::firstOrCreate(['name' => $data['category_name']]);
//     $brand = Brand::firstOrCreate([
//         'name' => $data['brand_name'],
//         'category_id' => $category->id
//     ]);

//     $supplier = null;
//     if(!empty($data['supplier_name'])){
//         $supplier = Supplier::firstOrCreate(['name' => $data['supplier_name']]);
//     }

//     return response()->json([
//         'success' => true,
//         'message' => 'บันทึกประเภท/แบรนด์/ซัพพลายเออร์เรียบร้อย!',
//         'category_id' => $category->id,
//         'brand_id' => $brand->id,
//         'supplier_id' => $supplier->id ?? null
//     ]);
// }





// public function productList()
// {
//     $categories = Category::all();
//     $brands = Brand::all();
//     $suppliers = Supplier::all();

//     // แค่ส่งข้อมูลทั้งหมดไปให้ view แต่ยังไม่แสดงจนกว่าจะเลือก
//     $products = Product::with(['category', 'brand', 'supplier'])->get();

//     return view('productlist', compact('products', 'categories', 'brands', 'suppliers'));}



//     // หน้าหลัก POS
//     public function home()
//     {
//         $products = Product::all();
//         return view('home', compact('products'));
//     }

//     // ดึง Brand ตาม Category (AJAX)
//    // ดึง Brand ตาม Category (ใช้ id แทนชื่อ)
// public function getBrandsByCategory($category_id)
// {
//     $category = Category::where('id', $category_id)->first();
//     if (!$category) return response()->json([]);
//     $brands = Brand::where('category_id', $category->id)->get();
//     return response()->json($brands);
// }


// public function getProducts(Request $request)
// {
//     $query = Product::query()->with(['category','brand','supplier']);

//     if ($request->category_id) $query->where('category_id', $request->category_id);
//     if ($request->supplier_id) $query->where('supplier_id', $request->supplier_id);

//     $products = $query->get()->map(function($p){
//         return [
//             'id' => $p->id,
//             'product_code' => $p->product_code,
//             'product_name' => $p->product_name,
//             'category_name' => $p->category?->name,
//             'brand_name' => $p->brand?->name,
//             'supplier_name' => $p->supplier?->name,
//             'cost_price' => $p->cost_price,
//             'retail_price' => $p->retail_price,
//             'wholesale_price' => $p->wholesale_price,
//             'stock_unit' => $p->stock_unit,
//             'stock_quantity' => $p->stock_quantity,
//         ];
//     });

//     return response()->json($products);
// }

// // เพิ่ม Product จากหน้า productlist
// public function addProductFromList(Request $request)
// {
//     $request->validate([
//         'product_name' => 'required',
//         'category_id' => 'required',
//         'brand_id' => 'required',
//         'supplier_id' => 'nullable',
//         'cost_price' => 'required|numeric',
//         'stock_unit' => 'required'
//     ]);

//     $productCode = $this->generateProductCode();

//     $product = Product::create([
//         'product_code' => $productCode,
//         'product_name' => $request->product_name,
//         'category_id' => $request->category_id,
//         'brand_id' => $request->brand_id,
//         'supplier_id' => $request->supplier_id,
//         'cost_price' => $request->cost_price,
//         'retail_price' => $request->retail_price,
//         'wholesale_price' => $request->wholesale_price,
//         'stock_unit' => $request->stock_unit,
//         'stock_quantity' => $request->stock_quantity,
//     ]);

//     return response()->json(['success' => true, 'message' => 'เพิ่มสินค้าเรียบร้อย!']);
// }

// public function addFromList(Request $request)
// {
//     $data = $request->only([
//         'product_name', 'category_id', 'brand_id', 'supplier_id',
//         'cost_price', 'retail_price', 'wholesale_price', 'stock_unit', 'stock_quantity'
//     ]);

//     $product = Product::create($data);

//     return response()->json([
//         'success' => true,
//         'message' => 'เพิ่มสินค้าสำเร็จ',
//         'product_id' => $product->id
//     ]);
// }

// public function ajaxProducts(Request $request)
// {
//     $query = Product::query()->with(['category','brand','supplier']);

//     if($request->category_id) $query->where('category_id', $request->category_id);
//     if($request->supplier_id) $query->where('supplier_id', $request->supplier_id);

//     $products = $query->get()->map(function($p){
//         return [
//             'id' => $p->id,
//             'product_name' => $p->product_name,
//             'product_code' => $p->product_code,
//             'category_id' => $p->category_id,
//             'category_name' => $p->category->name ?? '',
//             'brand_id' => $p->brand_id,
//             'brand_name' => $p->brand->name ?? '',
//             'supplier_id' => $p->supplier_id,
//             'supplier_name' => $p->supplier->name ?? '',
//             'cost_price' => $p->cost_price,
//             'retail_price' => $p->retail_price,
//             'wholesale_price' => $p->wholesale_price,
//             'stock_unit' => $p->stock_unit,
//             'stock_quantity' => $p->stock_quantity,
//         ];
//     });

//     return response()->json($products);
// // }











// เก่า



// public function home()
// {
//     $products = Product::all();
//     return view('home', compact('products'));
// }
// public function generateProductCode()
// {
//     $last = ProductItem::latest('id')->first();
//     $number = $last ? $last->id + 1 : 1;
//     return 'P' . str_pad($number, 5, '0', STR_PAD_LEFT);
// }

// // หน้า Add Product Item
// public function add()
// {
//     $categories = Category::all();
//     $brands = Brand::all();
//     $suppliers = Supplier::all();
//     $productCode = $this->generateProductCode();

//     return view('add', compact('categories','brands','suppliers','productCode'));
// }






// public function getBrandsByCategory($category_id)
// {
//     $brands = Brand::where('category_id', $category_id)->get();
//     return response()->json($brands);
// }

// public function getProducts(Request $request)
// {
//     $query = Product::query()->with(['category','brand','supplier']);
//     if ($request->category_id) $query->where('category_id', $request->category_id);
//     if ($request->supplier_id) $query->where('supplier_id', $request->supplier_id);
//     return response()->json($query->get());
// }


// // บันทึก Product Item
// public function storeProductItem(Request $request)
// {
//     $request->validate([
//         'category_name' => 'required',
//         'brand_name' => 'required',
//         'product_name' => 'required',
//         'cost_price' => 'required|numeric',
//         'stock_unit' => 'required'
//     ]);


//     $category = Category::firstOrCreate(['name' => $request->category_name]);
//     $brand = Brand::firstOrCreate([
//         'name' => $request->brand_name,
//         'category_id' => $category->id
//     ]);
//     $supplier = null;
//     if($request->supplier_name){
//         $supplier = Supplier::firstOrCreate(['name' => $request->supplier_name]);
//     }

//     $productItem = ProductItem::create([
//         'category_id' => $category->id,
//         'brand_id' => $brand->id,
//         'supplier_id' => $supplier?->id,
//         'product_code' => $this->generateProductCode(),
//         'product_name' => $request->product_name,
//         'cost_price' => $request->cost_price,
//         'retail_price' => $request->retail_price,
//         'wholesale_price' => $request->wholesale_price,
//         'stock_unit' => $request->stock_unit,
//         'stock_quantity' => $request->stock_quantity ?? 0,
//     ]);

//     return response()->json([
//         'success' => true,
//         'message' => 'เพิ่มสินค้าเรียบร้อย!',
//         'product_id' => $productItem->id,
//         'category_id' => $category->id,
//         'brand_id' => $brand->id,
//         'supplier_id' => $supplier?->id
//     ]);
// }

// // ดึงรายละเอียด Product Item
// public function getProductItem($id)
// {
//     $product = ProductItem::with(['category','brand','supplier'])->find($id);
//     if(!$product) return response()->json([]);
//     return response()->json($product);
// }

// // หน้า ProductList
// public function productList()
// {
//     $categories = Category::all();
//     $brands = Brand::all();
//     $suppliers = Supplier::all();
//     $products = Product::with(['category','brand','supplier'])->get();
//     return view('productlist', compact('products', 'categories','brands','suppliers'));
// }

// // เพิ่มสินค้าไป POS (products table)
// public function addProductToPOS(Request $request)
// {
//     $request->validate([
//         'product_item_id' => 'required|exists:product_items,id'
//     ]);

//     $item = ProductItem::find($request->product_item_id);

//     $product = Product::create([
//         'product_code' => $item->product_code,
//         'product_name' => $item->product_name,
//         'category_id' => $item->category_id,
//         'brand_id' => $item->brand_id,
//         'supplier_id' => $item->supplier_id,
//         'cost_price' => $item->cost_price,
//         'retail_price' => $item->retail_price,
//         'wholesale_price' => $item->wholesale_price,
//         'stock_unit' => $item->stock_unit,
//         'stock_quantity' => $item->stock_quantity,
//     ]);

//     return response()->json(['success' => true, 'message' => 'เพิ่มสินค้าสำหรับขายเรียบร้อย']);
// }









// public function index()
// {
//     $products = Product::all(); // ดึงข้อมูลสินค้าทั้งหมด
//     return view('productlist', compact('products'));
// }

    // แสดงหน้า product list
    // public function productList()
    // {
    //     $categories = Category::all();
    //     $brands = Brand::all();
    //     $suppliers = Supplier::all();

    //     // products table = รายการที่เลือกมาขายแล้ว
    //     $products = Product::with(['category','brand','supplier'])->get();

    //     return view('productlist', compact('products', 'categories', 'brands', 'suppliers'));
    // }

    // API: ดึงสินค้าใน product_items ตามเงื่อนไข

    public function getProducts(Request $request)
    {
        $query = ProductItem::query()->with(['category','brand','supplier']);
        if ($request->category_id) $query->where('category_id', $request->category_id);
        if ($request->brand_id) $query->where('brand_id', $request->brand_id);
        if ($request->supplier_id) $query->where('supplier_id', $request->supplier_id);
        return response()->json($query->get());
    }

    // เพิ่มจาก product_items → products
    // public function addProductToPOS(Request $request)
    // {
    //     $request->validate([
    //         'product_item_id' => 'required|exists:product_items,id'
    //     ]);

    //     $item = ProductItem::findOrFail($request->product_item_id);

    //     Product::create([
    //         'product_code' => $item->item_code,
    //         'product_name' => $item->item_name,
    //         'category_id' => $item->category_id,
    //         'brand_id' => $item->brand_id,
    //         'supplier_id' => $item->supplier_id,
    //         'cost_price' => $item->cost_price,
    //         'retail_price' => $item->retail_price,
    //         'wholesale_price' => $item->wholesale_price,
    //         'stock_unit' => $item->stock_unit,
    //         'stock_quantity' => $item->stock_quantity ?? 0,
    //     ]);

    //     return response()->json(['success' => true, 'message' => 'เพิ่มสินค้าไปขายเรียบร้อย!']);
    // }

    // หน้า POS (home)
    public function home()
    {
        $products = Product::all();
        return view('home', compact('products'));
    }

    // public function productList()
    // {
    //     $categories = Category::all();
    //     $brands = Brand::all();
    //     $suppliers = Supplier::all();
    //     $products = ProductItem::with(['category','brand','supplier'])->get(); // ดึงจาก master

    //     return view('productlist', compact('products', 'categories', 'brands', 'suppliers'));
    // }
    // เก็บไว้แค่ฟังก์ชันนี้
public function productList()
{
    $categories = Category::all();
    $brands = Brand::all();
    $suppliers = Supplier::all();
    $products = ProductItem::with(['category','brand','supplier'])->get(); // ดึงจาก master

    return view('productlist', compact('products', 'categories', 'brands', 'suppliers'));
}


    public function addProductToPOS(Request $request)
    {
        $request->validate([
            'product_item_id' => 'required|exists:product_items,id'
        ]);

        $item = ProductItem::findOrFail($request->product_item_id);

        Product::create([
            'product_code' => $item->item_code,
            'product_name' => $item->item_name,
            'category_id' => $item->category_id,
            'brand_id' => $item->brand_id,
            'supplier_id' => $item->supplier_id,
            'cost_price' => $item->cost_price,
            'retail_price' => $item->retail_price,
            'wholesale_price' => $item->wholesale_price,
            'stock_unit' => $item->stock_unit,
            'stock_quantity' => $item->stock_quantity ?? 0,
        ]);

        return response()->json(['success' => true, 'message' => 'เพิ่มสินค้าไปขายเรียบร้อย!']);
    }

// public function ajaxProducts()
// {
//     $products = Product::orderBy('id', 'desc')->get(['id','product_name']);
//     return response()->json($products);
// }




}

