<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockMovement;

class StockController extends Controller
{

    public function stock(Request $request)
    {
        // ดึงสินค้าพร้อม ProductItem

        $products = Product::with('productItem')
            ->when($request->search, function($q) use ($request){
                $q->where('product_code','like','%'.$request->search.'%')
                  ->orWhereHas('productItem', function($q2) use ($request){
                      $q2->where('item_name','like','%'.$request->search.'%');
                  });
            })
            ->orderBy('product_code')
            ->paginate(20);


     // ดึงการเคลื่อนไหวสต็อกพร้อม Product -> ProductItem
        $stockMovements = StockMovement::with('product.productItem')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return view('stock', compact('products','stockMovements'));
    }




// public function index(Request $request)
// {
//     $query = Product::whereHas('productItem') // เฉพาะสินค้าที่มี ProductItem
//                     ->with('productItem');

//     if ($request->has('search') && $request->search !== '') {
//         $query->whereHas('productItem', function($q) use ($request) {
//             $q->where('item_name', 'like', '%' . $request->search . '%');
//         })->orWhere('product_code', 'like', '%' . $request->search . '%');
//     }

//     $products = $query->orderBy('product_code')->paginate(20);

//     $stockMovements = StockMovement::whereHas('product.productItem')
//                     ->with('product.productItem')
//                     ->latest()
//                     ->limit(50)
//                     ->get();

//     return view('stock', compact('products', 'stockMovements'));
// }

    // เพิ่มสต็อก
    public function increase(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $product->stock_quantity += $request->quantity;
        $product->save();

        StockMovement::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'movement_type' => 'in',
            'note' => 'เพิ่มสต็อกจากหน้า stock',
        ]);

        return redirect()->back()->with('success', 'เพิ่มสต็อกเรียบร้อยแล้ว');
    }

    public function decrease(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity'   => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($request->product_id);

    if ($product->stock_quantity < $request->quantity) {
        return back()->with('error', 'สต็อกไม่พอสำหรับการขาย');
    }

    // ลดจำนวน
    $product->stock_quantity -= $request->quantity;
    $product->save();

    // บันทึกการเคลื่อนไหวแบบออก
    StockMovement::create([
        'product_id'    => $product->id,
        'quantity'      => $request->quantity,
        'movement_type' => 'out',
        'note'          => 'ขายสินค้าออกจาก stock',
    ]);

    return back()->with('success', 'ตัดสต็อกเรียบร้อยแล้ว');
}

//ใหม่

    // public function index()
    // {
    //     $product = Product::with('productItem')->first();
    //     dd($product->product_code, $product->productItem);

    //     return view('stock', compact('products'));
    // }

    // public function stock2()
    // {
    //     return view('stock2');
    // }



    public function stock2()
{
    // ดึงข้อมูลการเคลื่อนไหวสต็อกจากฐานข้อมูล
    $stockMovements = StockMovement::with('product.productItem')->latest()->get();

    // ส่งตัวแปรไปยัง view
    return view('stock2', compact('stockMovements'));
}

public function stockmove()
{
    $stockMovements = StockMovement::with('product.productItem')->orderBy('created_at', 'desc')->get();
    return view('stock2', compact('stockMovements'));
}
public function addStock(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'qty' => 'required|integer|min:1'
    ]);

    $product = Product::findOrFail($request->product_id);

    $product->stock_quantity += (int)$request->qty;
    $product->save();

    StockMovement::create([
        'product_id' => $product->id,
        'movement_type' => 'in',
        'quantity' => $request->qty,
        'note' => 'รับสินค้าเข้า'
    ]);

    return response()->json(['success'=>true]);
}








}
