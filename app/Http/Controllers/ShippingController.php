<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    //
    // public function shipping()
    // {$orders = Order::where('is_delivery', 1)
    //     ->orderBy('created_at', 'desc')
    //     ->get();



    //                     // dd($orders->toArray());
    //     return view('shipping', compact('orders'));
    // }

    // อัปเดตสถานะออเดอร์
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('shippingblade')->with('success', 'อัปเดตสถานะเรียบร้อยแล้ว');
    }
    public function shipping()
    {
        $orders = Order::with('orderDetails.product') // โหลดความสัมพันธ์ orderDetails + product
            ->where('is_delivery', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('shipping', compact('orders'));
    }

    public function orderDetails(Order $order) {
        $order->load('orderDetails.product.productItem'); // ✅ โหลดไปถึง productItem

        return response()->json([
            'items' => $order->orderDetails->map(function($item){
                return [
                    'name'  => $item->product->productItem->item_name ?? '-',   // ✅ ชื่อจาก product_items
                    'price' => (float) $item->unit_price,
                    'qty'   => (int) $item->quantity,
                    'total' => (float) $item->total_price,
                ];
            })
        ]);
    }

     // แสดงหน้าออเดอร์ที่ต้องจัดส่ง
    //  public function index()
    //  {
    //      $orders = Order::with(['customer', 'orderDetails.product'])
    //          ->where('is_delivery', 1)
    //          ->orderBy('created_at', 'desc')
    //          ->get();

    //      return view('shipping', compact('orders'));
    //  }
    public function index()
{
    $orders = Order::with([
        'customer',
        'orderDetails.product.productItem' // ต้องแน่ใจว่ามี productItem()
    ])
    ->where('is_delivery', 1)
    ->orderBy('created_at', 'desc')
    ->get();


    return view('shipping', compact('orders'));
}
// public function getTotalPriceWithVatAttribute()
// {
//     return $this->total_price * 1.07; // ถ้ายังไม่บันทึกลง DB
// }
public function getTotalPriceWithVatAttribute($value)
{
    if($value) return $value; // ถ้ามีค่าใน DB
    return $this->total_price * 1.07; // คำนวณ VAT 7%
}



     // ปริ้นออเดอร์ที่เลือก
     public function printOrders(Request $request)
     {
         $orderIds = $request->order_ids ?? [];
         $orders = Order::with(['customer', 'orderDetails.product'])
             ->whereIn('id', $orderIds)
             ->get();

         // ตัวอย่าง: return เป็น view สำหรับปริ้น
         return view('shipping_print', compact('orders'));
         // หรือคุณอาจใช้ PDF generator เช่น dompdf หรือ laravel-snappy
     }






}
