<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\StockMovement;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use App\Models\StoreSetting;


class OrderController extends Controller
{
    // public function store(Request $request)
    // {
    //     // ตรวจสอบข้อมูล
    //     $request->validate([
    //         'selected_products' => 'required|string',
    //         'transfer_number' => 'required|string'
    //     ]);

    //     $productsData = json_decode($request->selected_products, true);

    //     if (empty($productsData)) {
    //         return redirect()->route('home')->with('error', 'ไม่พบข้อมูลสินค้าในคำสั่งซื้อ');
    //     }

    //     // สร้างคำสั่งซื้อ
    //     $totalPrice = 0;
    //     $outOfStockProducts = [];

    //     $order = Order::create([
    //         'customer_phone' => $request->transfer_number,
    //         'total_price' => 0,
    //         'status' => 'pending'
    //     ]);

    //     foreach ($productsData as $item) {
    //         $product = Product::find($item['id']);

    //         $totalPrice += $item['total'];

    //         OrderDetail::create([
    //             'orders_id' => $order->id,
    //             'product_id' => $item['id'],
    //             'quantity' => $item['quantity'],
    //             'unit_price' => $item['price'],
    //             'price_type' => $item['price_type'], // เดิม
    //             // 'price_type' => $item['price_type'] ?? 'retail_price', //ใหม่
    //             'total_price' => $item['total']
    //         ]);

    //         $product->decrement('min_stock', $item['quantity']);

    //         // บันทึกการเคลื่อนไหวสต็อก "ออก"
    //         StockMovement::create([
    //             'product_id' => $item['id'],
    //             'quantity' => -1 * $item['quantity'], // ติดลบแปลว่า "ออก"
    //             'movement_type' => 'ออก',
    //             'note' => 'ขายสินค้าในคำสั่งซื้อ #' . $order->id,
    //         ]);


    //     }

    //     // ตรวจสอบสต๊อค
    //     if (!empty($outOfStockProducts)) {
    //         return redirect()->route('home')->with('error', 'สินค้า ' . implode(', ', $outOfStockProducts) . ' ไม่มีในสต๊อค');
    //     }
    //     $order->update([
    //         'total_price' => $totalPrice,
    //         'status' => 'completed' // หรือ 'success' ตามค่าที่คุณใช้ในฐานข้อมูล
    //     ]);



    //     return redirect()->route('home')->with('success', 'คำสั่งซื้อของคุณถูกบันทึกแล้ว!');
    // }


    //ใหม่
//     public function store(Request $request)
// {
//     $request->validate([
//         'selected_products' => 'required|string',
//         'transfer_number' => 'required|string'
//     ]);

    //     $productsData = json_decode($request->selected_products, true);
//     if (empty($productsData)) {
//         return redirect()->route('home')->with('error', 'ไม่พบข้อมูลสินค้าในคำสั่งซื้อ');
//     }

    //     $totalPrice = 0;
//     $order = Order::create([
//         'customer_phone' => $request->transfer_number,
//         'total_price' => 0,
//         'status' => 'pending'
//     ]);

    //     foreach ($productsData as $item) {
//         $product = Product::find($item['id']);
//         if (!$product) continue; // ถ้าไม่เจอข้ามไป

    //         $totalPrice += $item['total'];

    //         OrderDetail::create([
//             'orders_id' => $order->id,
//             'product_id' => $item['id'],
//             'quantity' => $item['quantity'],
//             'unit_price' => $item['price'],
//             'price_type' => $item['price_type'],
//             'total_price' => $item['total']
//         ]);

    //         $product->decrement('min_stock', $item['quantity']);

    //         StockMovement::create([
//             'product_id' => $item['id'],
//             'quantity' => -1 * $item['quantity'],
//             'movement_type' => 'ออก',
//             'note' => 'ขายสินค้าในคำสั่งซื้อ #' . $order->id,
//         ]);
//     }

    //     $order->update([
//         'total_price' => $totalPrice,
//         'status' => 'completed'
//     ]);

    //     return redirect()->route('home')->with('success', 'คำสั่งซื้อของคุณถูกบันทึกแล้ว!');
// }

    public function store(Request $request)
    {
        $request->validate([
            'selected_products' => 'required|string',
            // อย่าบังคับ 'transfer_number' เพราะผู้ใช้อาจไม่กรอก
        ]);

        $productsData = json_decode($request->selected_products, true);
        if (empty($productsData)) {
            return redirect()->route('home')->with('error', 'ไม่พบข้อมูลสินค้าในคำสั่งซื้อ');
        }

        $totalPrice = 0;

        // ตรวจสอบเบอร์ ถ้าไม่กรอกให้เก็บเป็น null
        $customerPhone = $request->transfer_number ?? null;

        // $customer = \App\Models\Customer::where('phone', $customerPhone)->first();
        // $isWholesale = $customer ? true : false;
        $customer = \App\Models\Customer::where('phone', $customerPhone)->first();

        $isWholesale = false;

        if ($customer && $customer->canUseWholesale()) {
            $isWholesale = true;
        }

        $order = Order::create([
            'customer_phone' => $customerPhone,
            'total_price' => 0,
            'status' => 'pending_delivery'
        ]);

        foreach ($productsData as $item) {
            $product = Product::with('productItem')->find($item['id']);
            if (!$product)
                continue;

            // 🔥 เลือกราคาเองใน backend
            $price = $isWholesale
                ? ($product->productItem->wholesale_price ?? $product->productItem->retail_price)
                : $product->productItem->retail_price;

            $total = $price * $item['quantity'];

            $totalPrice += $total;

            OrderDetail::create([
                'orders_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $price,
                'price_type' => $isWholesale ? 'wholesale_price' : 'retail_price',
                'total_price' => $total
            ]);

            $product->decrement('min_stock', $item['quantity']);

            StockMovement::create([
                'product_id' => $item['id'],
                'quantity' => -1 * $item['quantity'],
                'movement_type' => 'ออก',
                'note' => 'ขายสินค้าในคำสั่งซื้อ #' . $order->id,
            ]);
        }

        $order->update([
            'total_price' => $totalPrice
            // 'status' => 'completed'
        ]);

        if ($customer) {
            $customer->updateLoyalty($totalPrice);
        }

        return redirect()->route('home')->with('success', 'คำสั่งซื้อของคุณถูกบันทึกแล้ว!');
    }



    public function index(Request $request)
    {
        $query = Order::with('orderDetails.product');

        if ($request->filled('order_id')) {
            $query->where('id', $request->order_id);
        }

        if ($request->filled('order_date')) {
            $query->whereDate('created_at', $request->order_date);
        }

        $orders = $query->get();

        return view('saledata', compact('orders'));
    }

    public function proofList()
    {
        $orders = Order::whereNotNull('delivery_image')->get();

        return view('order_proof', compact('orders'));
    }

    public function showProof($id)
    {
        $order = Order::findOrFail($id);

        return view('order_proof_detail', compact('order'));
    }

    public function pdf($id)
    {
        $order = Order::with([
            'customer',
            'orderDetails.product.productItem'
        ])->findOrFail($id);

        // ดึงข้อมูลร้านค้า
        $store = StoreSetting::first();

        // ยอดก่อน VAT
        $subtotal = $order->orderDetails->sum('total_price');

        // VAT 7%
        $vat = $subtotal * 0.07;

        // ยอดรวม VAT
        $grandTotal = $subtotal + $vat;

        $html = view('pdf.order', compact(
            'order',
            'store',
            'subtotal',
            'vat',
            'grandTotal'
        ))->render();

        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        // dd(
        //     public_path('storage/fonts/THSarabunNew.ttf'),
        //     file_exists(public_path('storage/fonts/THSarabunNew.ttf')),
        //     public_path('storage/fonts/sarabun.ttf'),
        //     file_exists(public_path('storage/fonts/sarabun.ttf'))
        // );

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',

            'fontDir' => array_merge($fontDirs, [
                public_path('storage/fonts'),
            ]),

            'fontdata' => $fontData + [
                'sarabun' => [
                    'R' => 'THSarabunNew.ttf',
                    'B' => 'THSarabunNew.ttf',
                ],
            ],

            'default_font' => 'sarabun',
        ]);

        $mpdf->WriteHTML($html);

        return response(
            $mpdf->Output(
                'order-' . $order->id . '.pdf',
                'S'
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="order-' . $order->id . '.pdf"',
            ]
        );
    }

}
