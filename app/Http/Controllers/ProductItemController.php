<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\ProductItem;

class ProductItemController extends Controller
{


    // public function pro()
// {
//     $products = Product::all();
//     return view('add', compact('products'));
// }


    private function generateItemCode()
    {
        $last = ProductItem::latest('id')->first();
        $number = $last ? $last->id + 1 : 1;
        return 'I' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }


    // public function create()
    // {
    //     $categories = Category::all();
    //     $brands = Brand::all();
    //     $suppliers = Supplier::all();
    //     $itemCode = $this->generateItemCode();
    //     $products = ProductItem::with(['category', 'brand', 'supplier'])->get(); // เพิ่มตรงนี้

    //     return view('add', compact('categories', 'brands', 'suppliers', 'itemCode', 'products'));
    // }
    public function create()
{
    $categories = Category::all();
    $brands = Brand::all();
    $suppliers = Supplier::all();
    $itemCode = $this->generateItemCode();
    $products = ProductItem::with(['category', 'brand', 'supplier'])->get();

    // ดึง stock_unit แบบไม่ซ้ำ
    $units = Unit::where('is_active', true)
    ->orderBy('name')
    ->get();

    return view('add', compact('categories', 'brands', 'suppliers', 'itemCode', 'products', 'units'));
}





    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'category_id' => 'required',
            'brand_id' => 'required',
            'supplier_id' => 'nullable',
            'cost_price' => 'required|numeric',
            'retail_price' => 'nullable|numeric',
            'wholesale_price' => 'nullable|numeric',
            'unit_id' => 'required|exists:units,id',
            'min_stock' => 'nullable|integer|min:0',
        ]);

        $category_id = $this->getOrCreateId(Category::class, $request->category_id);
        $brand_id = $this->getOrCreateId(Brand::class, $request->brand_id, $category_id);
        $supplier_id = $this->getOrCreateId(Supplier::class, $request->supplier_id);

        // dd($request->all());
        $product = ProductItem::create([
            'item_code' => $this->generateItemCode(),
            'item_name' => $request->item_name,
            'category_id' => $category_id,
            'brand_id' => $brand_id,
            'supplier_id' => $supplier_id,
            'cost_price' => $request->cost_price,
            'retail_price' => $request->retail_price,
            'wholesale_price' => $request->wholesale_price,
            'unit_id' => $request->unit_id,
            'min_stock' => $request->min_stock,
            'stock_quantity' => $request->stock_quantity,

        ]);

        // ✅ เพิ่มตรงนี้
        Product::create([
            'product_item_id' => $product->id,
            'product_code' => $product->item_code,
            'stock_quantity' => $request->stock_quantity ?? 0,
        ]);


        if ($request->ajax()) {
            // สร้าง HTML ของ card สินค้าใหม่
            $html = '<div class="col-md-4 mb-3" id="product-card-' . $product->id . '">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">' . $product->item_name . '</h5>
                            <p class="mb-1"><strong>รหัส:</strong> ' . $product->item_code . '</p>
                            <p class="mb-1"><strong>Category:</strong> ' . ($product->category->name ?? '-') . '</p>
                            <p class="mb-1"><strong>Brand:</strong> ' . ($product->brand->name ?? '-') . '</p>
                            <p class="mb-1"><strong>Supplier:</strong> ' . ($product->supplier->name ?? '-') . '</p>
                            <p class="mb-1"><strong>ราคาปลีก:</strong> ' . number_format($product->retail_price, 2) . '</p>
                            <div class="d-flex justify-content-between mt-3">
                                <button class="btn btn-sm btn-warning editProductBtn" data-id="' . $product->id . '">แก้ไข</button>
                                <button class="btn btn-sm btn-danger deleteProductBtn" data-id="' . $product->id . '">ลบ</button>
                            </div>
                        </div>
                    </div>
                </div>';
                return response()->json([
                    'success' => true,
                    'message' => 'บันทึกสินค้าสำเร็จ!',
                    'html' => $html
                ]);
        }

        return redirect()->back()->with('success', 'บันทึกสินค้า Master สำเร็จ!');
    }


    // ฟังก์ชัน getOrCreateId
    private function getOrCreateId($modelClass, $value, $category_id = null)
    {
        $value = trim($value);
        if ($value === '')
            return null;

        if (is_numeric($value))
            return (int) $value;

        // ถ้าเป็น Brand ต้องส่ง category_id ด้วย
        if ($modelClass === Brand::class && $category_id) {
            $record = Brand::firstOrCreate(
                ['name' => $value, 'category_id' => $category_id]
            );
            return $record->id;
        }

        $record = $modelClass::firstOrCreate(['name' => $value]);
        return $record->id;
    }




    public function index()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $products = ProductItem::all(); // แสดงทั้งหมดในหน้า product list

        return view('productlist', compact('categories', 'brands', 'suppliers', 'products'));
    }

    // AJAX: Brand ตาม Category
    // public function getBrandsByCategory($category_id)
    // {
    //     $brands = ProductItem::where('category_id', $category_id)
    //         ->select('brand_id')
    //         ->distinct()
    //         ->with('brand')
    //         ->get()
    //         ->pluck('brand');
    //     return response()->json($brands);
    // }

    // AJAX: Supplier ตาม Category + Brand
    // public function getSuppliers(Request $request)
    // {
    //     $suppliers = ProductItem::where('category_id', $request->category_id)
    //         ->where('brand_id', $request->brand_id)
    //         ->select('supplier_id')
    //         ->distinct()
    //         ->with('supplier')
    //         ->get()
    //         ->pluck('supplier');
    //     return response()->json($suppliers);
    // }

    // AJAX: Products ตาม Category + Brand + Supplier
    public function getProducts(Request $request)
    {
        $products = ProductItem::with(['category', 'brand', 'supplier'])
            ->where('category_id', $request->category_id)
            ->where('brand_id', $request->brand_id)
            ->where('supplier_id', $request->supplier_id)
            ->get();

        return response()->json($products);
    }

    // เพิ่มสินค้าไป POS
    public function addFromList(Request $request)
    {
        // ตัวอย่าง: เพิ่มลง session หรือ database ตาราง POS
        $product = ProductItem::find($request->product_item_id);
        if (!$product)
            return response()->json(['success' => false, 'message' => 'ไม่พบสินค้า']);

        // ตัวอย่างเก็บลง session
        $cart = session()->get('cart', []);
        $cart[$product->id] = [
            'name' => $product->item_name,
            'code' => $product->item_code,
            'price' => $product->retail_price
        ];
        session()->put('cart', $cart);

        return response()->json(['success' => true, 'message' => 'เพิ่มสินค้าเรียบร้อย']);
    }

    // ลบสินค้า
    public function destroy($id)
    {
        $product = ProductItem::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'ไม่พบสินค้า']);
        }

        $product->delete();
        return response()->json(['success' => true, 'message' => 'ลบสินค้าสำเร็จ']);
    }

    // อัปเดตสินค้า
    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'category_id' => 'required',
            'brand_id' => 'required',
            'supplier_id' => 'nullable',
            'cost_price' => 'required|numeric',
            'retail_price' => 'nullable|numeric',
            'wholesale_price' => 'nullable|numeric',
            'unit_id' => 'required|exists:units,id',
            'min_stock' => 'nullable|integer|min:0',
        ]);

        $product = ProductItem::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'ไม่พบสินค้า']);
        }

        $category_id = $this->getOrCreateId(Category::class, $request->category_id);
        $brand_id = $this->getOrCreateId(Brand::class, $request->brand_id, $category_id);
        $supplier_id = $this->getOrCreateId(Supplier::class, $request->supplier_id);

        $product->update([
            'item_name' => $request->item_name,
            'category_id' => $category_id,
            'brand_id' => $brand_id,
            'supplier_id' => $supplier_id,
            'cost_price' => $request->cost_price,
            'retail_price' => $request->retail_price,
            'wholesale_price' => $request->wholesale_price,
            'unit_id' => $request->unit_id,
            'min_stock' => $request->min_stock,
        ]);

        return response()->json(['success' => true, 'message' => 'แก้ไขสินค้าสำเร็จ', 'product' => $product]);
    }

    public function show($id)
    {
        $product = ProductItem::with(['category', 'brand', 'supplier'])->find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'ไม่พบสินค้า']);
        }
        return response()->json(['success' => true, 'product' => $product]);
    }


//     public function getBrands($category_id)
// {
//     $brands = Brand::where('category_id',$category_id)->get();
//     return response()->json($brands);
// }

// public function getSuppliers($brand_id)
// {
//     $suppliers = Supplier::where('brand_id',$brand_id)->get();
//     return response()->json($suppliers);
// }

//ล่าสุด
// public function getBrandsByCategory($category_id)
// {
//     $brands = Brand::where('category_id', $category_id)->get();
//     return response()->json($brands);
// }
// public function getSuppliersByBrand($brand_id)
// {
//     $suppliers = Supplier::where('brand_id', $brand_id)->get();
//     return response()->json($suppliers);
// }
public function getBrandsByCategory($category_id)
{
    $brands = Brand::where('category_id', $category_id)
        ->orderBy('name')
        ->get();

    return response()->json($brands);
}
public function getSuppliersByBrand(Request $request)
{
    $suppliers = \App\Models\ProductItem::where('brand_id', $request->brand_id)
        ->select('supplier_id')
        ->distinct()
        ->with('supplier')
        ->get()
        ->pluck('supplier');

    return response()->json($suppliers);
}





// public function store(Request $request)
//     {
//         $request->validate([
//             'item_name' => 'required|string|max:255',
//             'category_id' => 'required|exists:categories,id',
//             'brand_id' => 'required|exists:brands,id',
//             'supplier_id' => 'nullable|exists:suppliers,id',
//             'cost_price' => 'required|numeric',
//             'retail_price' => 'nullable|numeric',
//             'wholesale_price' => 'nullable|numeric',
//             'stock_unit' => 'required|string|max:50',
//             'min_stock' => 'nullable|integer|min:0',
//         ]);

//         $itemCode = $this->generateItemCode(); // ✅ generate ที่นี่แทน

//         ProductItem::create([
//             'item_code' => $itemCode,
//             'item_name' => $request->item_name,
//             'category_id' => $request->category_id,
//             'brand_id' => $request->brand_id,
//             'supplier_id' => $request->supplier_id,
//             'cost_price' => $request->cost_price,
//             'retail_price' => $request->retail_price,
//             'wholesale_price' => $request->wholesale_price,
//             'stock_unit' => $request->stock_unit,
//             'min_stock' => $request->min_stock,
//         ]);

//         return redirect()->back()->with('success', 'บันทึกสินค้าสำเร็จ!');
//     }


//     public function create()
// {
//     $categories = Category::all();
//     $brands = Brand::all();
//     $suppliers = Supplier::all();
//     $itemCode = $this->generateItemCode();

//     return view('product-items.create', compact('categories', 'brands', 'suppliers', 'itemCode'));
// }



// public function generateItemCode()
// {
//     $last = ProductItem::latest('id')->first();
//     $number = $last ? $last->id + 1 : 1;
//     return 'I' . str_pad($number, 5, '0', STR_PAD_LEFT); // I00001
// }





}
