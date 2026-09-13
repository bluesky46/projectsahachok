<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;





class AdminController extends Controller
{

    // ดึงข้อมูลยอดขายจากตาราง orders
    // public function index()
    // {
    //     $sales = DB::table('orders')
    //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(COALESCE(total_price, 0)) as total_sales'))
    //         ->groupBy(DB::raw('DATE(created_at)'))
    //         ->orderBy('date', 'desc')
    //         ->get();

    //     // คำนวณยอดขายเฉลี่ย
    //     $average_sales = DB::table('orders')
    //         ->select(DB::raw('AVG(COALESCE(total_price, 0)) as average_sales'))
    //         ->first();

    //     // คำนวณยอดขายสูงสุด
    //     $highest_sales = DB::table('orders')
    //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(COALESCE(total_price, 0)) as total_sales'))
    //         ->groupBy(DB::raw('DATE(created_at)'))
    //         ->orderByDesc(DB::raw('SUM(COALESCE(total_price, 0))'))
    //         ->limit(1)
    //         ->first();

    //     // คำนวณยอดขายต่ำสุด
    //     $lowest_sales = DB::table('orders')
    //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(COALESCE(total_price, 0)) as total_sales'))
    //         ->groupBy(DB::raw('DATE(created_at)'))
    //         ->orderBy('total_sales')
    //         ->limit(1)
    //         ->first();

    //     // ส่งข้อมูลไปยัง view
    //     return view('adminHome', compact('sales', 'average_sales', 'highest_sales', 'lowest_sales'));


    // }

    public function home(Request $request)
    {
        $month = $request->input('month', date('Y-m'));

        // จำนวนคำสั่งซื้อวันนี้
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();

        // จำนวนคำสั่งซื้อเดือนนี้
        $monthOrders = Order::whereYear('created_at', substr($month, 0, 4))
            ->whereMonth('created_at', substr($month, 5, 2))
            ->count();

        // รายได้เดือนนี้
        $currentMonthRevenue = Order::whereYear('created_at', substr($month, 0, 4))
            ->whereMonth('created_at', substr($month, 5, 2))
            ->sum('total_price');

        // รายได้เดือนก่อน
        $prevMonth = date('Y-m', strtotime($month . ' -1 month'));
        $previousMonthRevenue = Order::whereYear('created_at', substr($prevMonth, 0, 4))
            ->whereMonth('created_at', substr($prevMonth, 5, 2))
            ->sum('total_price');

        // เปอร์เซ็นต์เปลี่ยนแปลง
        $percentageChange = 0;
        if ($previousMonthRevenue > 0) {
            $percentageChange = (($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100;
        } elseif ($currentMonthRevenue > 0) {
            $percentageChange = 100;
        }

        // เดือนที่เลือกได้
        $availableMonths = [
            date('Y-m', strtotime('-2 month')) => date('F Y', strtotime('-2 month')),
            date('Y-m', strtotime('-1 month')) => date('F Y', strtotime('-1 month')),
            date('Y-m') => date('F Y'),
        ];

        // ดึงรายการเคลื่อนไหวล่าสุด 5 รายการ
        $recentActivities = StockMovement::with('product')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

            $bestSellingProductsTop = OrderDetail::select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity')
            )
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->with(['product.productItem']) // ⭐ สำคัญ
            ->take(5)
            ->get();

        // ดึงสินค้าขายดีทั้งหมด
        $bestSellingProductsAll = OrderDetail::with('product')
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->get();

        return view('adminHome', compact(
            'currentMonthRevenue',
            'previousMonthRevenue',
            'percentageChange',
            'availableMonths',
            'todayOrders',
            'monthOrders',
            'recentActivities',
            'bestSellingProductsTop',
            'bestSellingProductsAll'
        )
        );
    }





    public function index(Request $request)
    {
        $month = $request->input('month', date('Y-m'));

        // คำนวณรายได้เดือนนี้และเดือนก่อนตาม $month
        $currentMonthRevenue = Order::whereYear('created_at', substr($month, 0, 4))
            ->whereMonth('created_at', substr($month, 5, 2))
            ->sum('total_price');

        $prevMonth = date('Y-m', strtotime($month . ' -1 month'));
        $previousMonthRevenue = Order::whereYear('created_at', substr($prevMonth, 0, 4))
            ->whereMonth('created_at', substr($prevMonth, 5, 2))
            ->sum('total_price');

        $percentageChange = 0;
        if ($previousMonthRevenue > 0) {
            $percentageChange = (($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100;
        } elseif ($currentMonthRevenue > 0) {
            $percentageChange = 100;
        }

        // โหลดข้อมูลอื่น ๆ (lowStockProducts, bestSellingProducts, etc.) เหมือนเดิม

        // สินค้าใกล้หมดสต็อก (Top 5)
        // $lowStockProductsTop = Product::select('products.id', 'products.product_code', 'products.product_name')
        // ->selectRaw("
        //     COALESCE(SUM(
        //         CASE
        //             WHEN stock_movements.movement_type = 'in' THEN stock_movements.quantity
        //             WHEN stock_movements.movement_type = 'out' THEN -stock_movements.quantity
        //             ELSE 0
        //         END
        //     ), 0) as current_stock
        // ")
        // ->leftJoin('stock_movements', 'products.id', '=', 'stock_movements.product_id')
        // ->groupBy('products.id', 'products.product_code', 'products.product_name')
        // ->havingRaw('current_stock <= 10')
        // ->orderBy('current_stock', 'asc')
        // ->limit(5)
        // ->get();'

        $lowStockProductsTop = Product::select(
            'products.id',
            'products.product_code',
            'product_items.item_name as product_name' // <-- ใช้ชื่อจาก table product_items
        )
            ->selectRaw("
            COALESCE(SUM(
                CASE
                    WHEN stock_movements.movement_type = 'in' THEN stock_movements.quantity
                    WHEN stock_movements.movement_type = 'out' THEN -stock_movements.quantity
                    ELSE 0
                END
            ), 0) as current_stock
        ")
            ->leftJoin('stock_movements', 'products.id', '=', 'stock_movements.product_id')
            ->leftJoin('product_items', 'products.product_item_id', '=', 'product_items.id') // <-- join กับ product_items
            ->groupBy('products.id', 'products.product_code', 'product_items.item_name')
            ->havingRaw('current_stock <= 10')
            ->orderBy('current_stock', 'asc')
            ->limit(5)
            ->get();


        // สำหรับ Modal แสดงทั้งหมด
        $lowStockProductsAll = Product::select(
            'products.id',
            'products.product_code',
            'product_items.item_name as product_name'
        )
        ->selectRaw("
            COALESCE(SUM(
                CASE
                    WHEN stock_movements.movement_type = 'in' THEN stock_movements.quantity
                    WHEN stock_movements.movement_type = 'out' THEN -stock_movements.quantity
                    ELSE 0
                END
            ), 0) as current_stock
        ")
        ->leftJoin('stock_movements', 'products.id', '=', 'stock_movements.product_id')
        ->leftJoin('product_items', 'products.product_item_id', '=', 'product_items.id')
        ->groupBy('products.id', 'products.product_code', 'product_items.item_name')
        ->orderBy('current_stock', 'asc')
        ->get();





        // สินค้าขายดี (Top 5)
        $bestSellingProductsTop = OrderDetail::select(
            'product_id',
            DB::raw('SUM(quantity) as total_quantity')
        )
        ->groupBy('product_id')
        ->orderByDesc('total_quantity')
        ->with(['product.productItem']) // ⭐ สำคัญ
        ->take(5)
        ->get();


        $bestSellingProductsAll = OrderDetail::select(
            'order_details.product_id',
            'product_items.item_name',
            DB::raw('SUM(order_details.quantity) as total_quantity')
        )
        ->join('products', 'order_details.product_id', '=', 'products.id')
        ->join('product_items', 'products.product_item_id', '=', 'product_items.id')
        ->groupBy('order_details.product_id', 'product_items.item_name')
        ->orderByDesc('total_quantity')
        ->get();




        // จำนวนคำสั่งซื้อวันนี้ / เดือนนี้
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();
        $monthOrders = Order::whereYear('created_at', substr($month, 0, 4))
            ->whereMonth('created_at', substr($month, 5, 2))
            ->count();

        // ยอดขายรายวัน (7 วันล่าสุด)
        $salesChart = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total_sales'))
            ->whereBetween('created_at', [Carbon::now()->subDays(6), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $salesLabels = $salesChart->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        })->toArray();

        $salesData = $salesChart->pluck('total_sales')->toArray();

        // fallback กัน null
        $salesLabels = $salesLabels ?? [];
        $salesData = $salesData ?? [];


        // รายการเคลื่อนไหวล่าสุด (StockMovement)
        $recentActivities = StockMovement::with('product')->orderBy('created_at', 'desc')->take(5)->get();

        // ยอดขายเฉลี่ยเดือนนี้
        $average_sales = Order::whereYear('created_at', substr($month, 0, 4))
            ->whereMonth('created_at', substr($month, 5, 2))
            ->avg('total_price');

        $highest_sales = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total_sales'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderByDesc('total_sales')
            ->first();

        $lowest_sales = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total_sales'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('total_sales')
            ->first();

        $availableMonths = [
            date('Y-m', strtotime('-2 month')) => date('F Y', strtotime('-2 month')),
            date('Y-m', strtotime('-1 month')) => date('F Y', strtotime('-1 month')),
            date('Y-m') => date('F Y'),
        ];
        $pendingCount = Order::where('status', 'pending')->count();
        $completedCount = Order::where('status', 'completed')->count();

        return view(
            'adminHome',
            compact(
                'lowStockProductsTop',
                'lowStockProductsAll',
                'bestSellingProductsTop',
                'bestSellingProductsAll',
                'currentMonthRevenue',
                'previousMonthRevenue',
                'percentageChange',
                'todayOrders',
                'monthOrders',
                'salesLabels',
                'salesData',
                'recentActivities',
                'availableMonths',
                'average_sales',
                'highest_sales',
                'lowest_sales',
                'pendingCount',
                'completedCount'
            )
        );

    }


    public function stockmove(Request $request)
    {
        $query = StockMovement::query();

        // ตัวกรองตามวันที่
        $query->when($request->start_date, function ($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->start_date);
        });

        $query->when($request->end_date, function ($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->end_date);
        });

        // ตัวกรองตามสินค้า
        $query->when($request->product_id, function ($q) use ($request) {
            $q->where('product_id', $request->product_id);
        });

        // ตัวกรองตามประเภทการเคลื่อนไหว
        $query->when($request->movement_type, function ($q) use ($request) {
            $q->where('movement_type', $request->movement_type);
        });

        $stockMovements = $query->with('product')->latest()->get(); // หรือ paginate()


        $products = Product::all();

        return view('adminstock', compact('stockMovements', 'products'));
    }




    public function exportStock(Request $request)
    {
        $query = StockMovement::query()->with('product');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        if ($request->filled('movement_type')) {
            $query->where('movement_type', $request->movement_type);
        }

        $stockMovements = $query->get();

        $exportData = $stockMovements->map(function ($item) {
            return [
                'รหัสสินค้า' => $item->product->product_code ?? '-',
                // 'ชื่อสินค้า' => $item->product->product_name ?? $item->note,
                'ชื่อสินค้า' => $item->product->productItem->item_name ?? $item->note,


                'จำนวน' => $item->quantity,
                'ประเภทการเคลื่อนไหว' => $item->movement_type,
                'วันที่' => $item->created_at->format('d/m/Y H:i'),
            ];
        });

        return \Excel::download(new \App\Exports\ArrayExport($exportData->toArray()), 'stock_movement.xlsx');
    }
    public function ordersSummary(Request $request)
{
    $type = $request->get('type', 'day'); // day | month
    $date = $request->get('date', now()->format('Y-m-d'));

    if ($type === 'day') {
        $orders = Order::whereDate('created_at', $date)->latest()->get();

        $orderCount = $orders->count();
        $totalRevenue = $orders->sum('total_price');

        $title = 'สรุปคำสั่งซื้อประจำวัน ' . Carbon::parse($date)->format('d/m/Y');

    } else {
        $orders = Order::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->latest()
            ->get();

        $orderCount = $orders->count();
        $totalRevenue = $orders->sum('total_price');

        $title = 'สรุปคำสั่งซื้อประจำเดือน ' . Carbon::parse($date)->format('m/Y');
    }

    return view('orders-summary', compact(
        'orders',
        'orderCount',
        'totalRevenue',
        'type',
        'date',
        'title'
    ));
}

public function showOrder(Order $order)
{
    // โหลดความสัมพันธ์ล่วงหน้า
    $order->load([
        'orderDetails.product',
        'customer'
    ]);

    return view('orderdetail', compact('order'));


}

public function shipping()
{
    $pendingCount = Order::where('status', 'pending')->count();
    $completedCount = Order::where('status', 'completed')->count();

    return view('admin.shipping', compact('pendingCount', 'completedCount'));
}


public function pendingOrders()
{
    $orders = Order::where('status', 'pending')->get();
    return view('pending-orders', compact('orders'));

}
public function bulkPrint(Request $request)
{
    $ids = $request->order_ids;

    if (empty($ids)) {
        return back()->with('error', 'กรุณาเลือกออเดอร์ก่อน!');
    }

    $ids = explode(',', $ids);

    $orders = Order::whereIn('id', $ids)
        ->with('orderDetails.product')
        ->get();

    $pdf = Pdf::loadView('bulk_invoice', compact('orders'));

    // return $pdf->stream('bulk_orders.pdf');
    $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);
$pdf->output();
return $pdf->stream('bulk_orders.pdf', ['Attachment' => false]);

}



//จัดการสิท
public function checkUsers()
{
    $users = User::orderBy('created_at','desc')->get();
    return view('admin.checkuser', compact('users'));
}
public function makeRider($id)
{
    $user = User::findOrFail($id);

    $user->update([
        'role' => 'rider'
    ]);

    return back()->with('success','แต่งตั้งเป็น Rider สำเร็จ');
}
public function removeRider($id)
{
    $user = User::findOrFail($id);

    $user->update([
        'role' => null
    ]);

    return back()->with('success','ถอด Rider สำเร็จ');
}
public function makeAdmin($id)
{
    $user = User::findOrFail($id);

    $user->update([
        'is_admin' => 1
    ]);

    return back()->with('success','แต่งตั้งเป็น Admin สำเร็จ');
}
public function removeAdmin($id)
{
    $user = User::findOrFail($id);

    if(auth()->id() == $user->id){
        return back()->with('error','ไม่สามารถถอดสิทธิ์ตัวเองได้');
    }

    $user->update([
        'is_admin' => 0
    ]);

    return back()->with('success','ถอดสิทธิ์ Admin สำเร็จ');
}

// public function showProof($id)
// {
//     $order = Order::with('orderDetails.product')->findOrFail($id);
//     return view('admin.delivery-proof', compact('order'));
// }
public function ordersToday()
{
    $orders = Order::whereDate('created_at', today())->get();
    return view('admin.today', compact('orders'));
}

public function ordersMonth()
{
    $orders = Order::whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->get();

    return view('admin.month', compact('orders'));
}

public function ordersPending()
{
    $orders = Order::where('status', 'pending')->get();
    return view('admin.pending', compact('orders'));
}

public function ordersCompleted()
{
    $orders = Order::where('status', 'completed')->get();
    return view('admin.completed', compact('orders'));
}

// public function proofList()
// {
//     $orders = Order::whereNotNull('delivery_image')->latest()->get();

//     return view('admin.completed', compact('orders'));
// }
public function proofList()
{
    $orders = Order::whereNotNull('delivery_image')->latest()->get();

    return view('admin.orders.proof', compact('orders'));
}

public function showProof($id)
{
    $order = Order::findOrFail($id);

  return view('admin.proof-show', compact('order'));
}



}
