<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StockMovement;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminHome()
    {
        return view('adminHome'); // ตรวจสอบว่ามีไฟล์ `resources/views/admin/home.blade.php`
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //ปัจจุบัน


    public function home(Request $request)
    {
        $query = Product::with('productItem');

        if ($request->filled('category_id')) {
            $query->whereHas('productItem', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        $products = $query->get();
        $categories = Category::all();
        $cart = session('cart', []);

        return view('home', compact('products', 'categories', 'cart'));
    }

    public function store(Request $request)
    {
        $productItem = ProductItem::find($request->product_item_id);

        if (!$productItem)
            return back()->with('error', 'ไม่พบสินค้า');

        Product::create([
            'product_item_id' => $productItem->id,
            'product_code' => $productItem->item_code,
            'stock_quantity' => $request->stock_quantity ?? 0,
        ]);

        return redirect()->route('home')->with('success', 'เพิ่มสินค้าเข้า POS แล้ว');

    }



    // public function sale(Request $request)
    // {

    //     if ($request->has('order_id') && !empty($request->order_id)) {
    //         //
    //         $orders = Order::with('orderDetails')
    //             ->where('id', $request->order_id)
    //             ->get();
    //     } else {
    //         $orders = Order::with('orderDetails')->get();
    //     }

    //     return view('saledata', compact('orders'));
    // }

    public function coildata()
    {
        return view('coil');
    }





    public function stockdata(Request $request)
    {

        $query = Product::select(
            'products.id',
            'products.product_code',
            'products.stock_quantity',
            'product_items.item_name as product_name'
        )
            ->leftJoin('product_items', 'products.product_item_id', '=', 'product_items.id');

        // ->leftJoin('product_items', 'products.product_item_id', '=', 'product_items.id');

        if ($request->has('search') && $request->search !== '') {
            $query->where(function ($q) use ($request) {
                $q->where('product_items.item_name', 'like', '%' . $request->search . '%')
                    ->orWhere('products.product_code', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->orderBy('product_items.item_name')->paginate(20);

        $stockMovements = StockMovement::with(['product.productItem'])
            ->whereHas('product.productItem') // filter ให้มี item เท่านั้น
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();


        return view('stock', compact('products', 'stockMovements'));
    }






}
