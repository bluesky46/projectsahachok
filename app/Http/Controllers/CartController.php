<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;


class CartController extends Controller
{
    // แสดงหน้า cart
    // public function index(Request $request)
    // {
    //     $cart = $request->session()->get('cart', []);
    //     $total = 0;
    //     foreach($cart as $item){
    //         $total += $item['price'] * $item['qty'];
    //     }
    //     return view('cart', compact('cart','total'));
    // }


    // public function add(Request $request){
    //     $cart = session()->get('cart', []);

    //     $id = $request->id;
    //     $qty = $request->qty ?? $request->input('qty', 0);
    //     $name = $request->name ?? '';
    //     $price = $request->price ?? 0;

    //     if(isset($cart[$id])){
    //         $cart[$id]['qty'] = $qty; // แก้ไข qty ให้ตรงกับ input
    //         if($request->price) $cart[$id]['price'] = $price; // อัปเดตราคาตามราคาส่งหรือปลีก
    //     } else {
    //         $cart[$id] = [
    //             'name' => $name,
    //             'price' => $price,
    //             'qty' => $qty
    //         ];
    //     }

    //     if($qty <= 0){
    //         unset($cart[$id]);
    //     }

    //     session(['cart' => $cart]);

    //     return response()->json([
    //         'cart_count' => count($cart),
    //         'current_qty' => $cart[$id]['qty'] ?? 0
    //     ]);
    // }

    // แสดงตะกร้า
    // public function index(Request $request)
    // {
    //     $sessionId = session()->getId();
    //     $cartItems = Cart::with('product.productItem')->where('session_id', $sessionId)->get();

    //     $cart = [];
    //     foreach($cartItems as $item){
    //         $cart[$item->product_id] = [
    //             'name' => $item->product->productItem->item_name ?? '',
    //             'price' => $item->unit_price,
    //             'qty' => $item->quantity,
    //         ];
    //     }

    //     return view('cart', compact('cart'));
    // }
    public function index(Request $request)
    {
        $sessionId = session()->getId();
        $cartItems = Cart::with('product.productItem')->where('session_id', $sessionId)->get();

        $cart = [];
        foreach ($cartItems as $item) {

            $cart[$item->product_id] = [
                'name' => $item->product->productItem->item_name ?? '',
                'price' => $item->unit_price,
                'qty' => $item->quantity,
                'retail_price' => $item->product->productItem->retail_price,
                'wholesale_price' => $item->product->productItem->wholesale_price,
                'price_type' => $item->price_type ?? 'ปลีก',
            ];
        }

        // ดึงข้อมูลลูกค้า
        $customers = Customer::select(
            'id',
            'name',
            'type',
            'phone',
            'contact_person',
            'address_number',
            'address_building',
            'address_street',
            'address_subdistrict',
            'address_district',
            'address_province',
            'postal_code'
        )
            ->orderBy('name')
            ->get();

        return view('cart', compact('cart', 'customers'));
    }


    // เพิ่ม/อัปเดตสินค้าในตะกร้า
    // public function add(Request $request)
    // {
    //     $sessionId = session()->getId();
    //     $productId = $request->id;
    //     $qty = $request->qty ?? 0;
    //     $priceType = $request->price_type ?? 'ปลีก';
    //     $price = $request->price ?? Product::find($productId)->productItem->retail_price;

    //     $cart = Cart::firstOrNew([
    //         'session_id' => $sessionId,
    //         'product_id' => $productId,
    //     ]);

    //     if ($qty <= 0) {
    //         $cart->delete();
    //     } else {
    //         $cart->unit_price = $price;
    //         $cart->quantity = $qty;
    //         $cart->total_price = $qty * $price;
    //         $cart->price_type = $priceType; // ✅ เพิ่มตรงนี้
    //         $cart->save();
    //     }

    //     $cartCount = Cart::where('session_id', $sessionId)->sum('quantity');


    //     return response()->json(['cart_count' => $cartCount, 'current_qty' => $qty]);
    // }
    public function add(Request $request)
    {
        $sessionId = session()->getId();
        $productId = $request->id;
        $qty = $request->qty ?? 0;

        $product = Product::with('productItem')->find($productId);

        if (!$product) {
            return response()->json(['error' => 'ไม่พบสินค้า'], 404);
        }

        // $priceType = $request->price_type ?? 'ปลีก';

        // // ✅ เลือกราคาตาม type
        // if ($priceType === 'ส่ง') {
        //     $price = $product->productItem->wholesale_price;
        // } else {
        //     $price = $product->productItem->retail_price;
        // }
        $customerPhone = $request->customer_phone ?? null;
        $customer = Customer::where('phone', $customerPhone)->first();

        $isWholesale = $customer && $customer->canUseWholesale();

        // 🎯 ให้ backend ตัดสินราคา
        if ($isWholesale) {
            $price = $product->productItem->wholesale_price ?? $product->productItem->retail_price;
            $priceType = 'ส่ง';
        } else {
            $price = $product->productItem->retail_price;
            $priceType = 'ปลีก';
        }

        $cart = Cart::firstOrNew([
            'session_id' => $sessionId,
            'product_id' => $productId,
        ]);

        if ($qty <= 0) {
            $cart->delete();
        } else {
            $cart->unit_price = $price;
            $cart->quantity = $qty;
            $cart->total_price = $qty * $price;
            $cart->price_type = $priceType;
            $cart->save();
        }

        $cartCount = Cart::where('session_id', $sessionId)->sum('quantity');

        return response()->json([
            'cart_count' => $cartCount,
            'current_qty' => $qty
        ]);
    }


    // สั่งซื้อ
    public function checkout(Request $request)
    {
        // dd($request->all());
        $sessionId = session()->getId();
        $cartItems = Cart::with('product.productItem')->where('session_id', $sessionId)->get();
        if ($cartItems->isEmpty())
            return back()->with('error', 'ไม่มีสินค้าในตะกร้า');

        $customerPhone = $request->customer_phone ?? null;
        $customer = null;

        if ($customerPhone) {
            $customer = Customer::firstOrCreate(
                ['phone' => $customerPhone],
                ['name' => $request->customer_name ?? 'ลูกค้าไม่ระบุ']
            );
        }

        /* ✅ ใส่ตรงนี้เลย */
        $customerType = 'ทั่วไป';

        if ($customer) {
            $customerType = $customer->type ?? 'ทั่วไป';
        }

        // $totalPrice = 0;
        // foreach ($cartItems as $item) {
        //     $totalPrice += $item->unit_price * $item->quantity;
        // }
        $totalPrice = 0;

        foreach ($cartItems as $item) {
            $totalPrice += $item->unit_price * $item->quantity;
        }

        // ตรวจสอบว่าลูกค้าเลือกจัดส่งหรือไม่
        $isDelivery = $request->boolean('is_delivery');

        // $order = Order::create([
        //     'customer_phone' => $customerPhone,
        //     // 'total_price' => $totalPrice,
        //     'total_price' => $itemTotal,
        //     'status' => $isDelivery ? 'pending_delivery' : 'completed',
        //     'is_delivery' => $isDelivery ? 1 : 0,
        // ]);
        $order = Order::create([
            'customer_phone' => $customerPhone,
            'total_price' => $totalPrice,
            // ✅ ใช้ตัวนี้เท่านั้น
            'status' => $isDelivery ? 'pending_delivery' : 'completed',
            'is_delivery' => $isDelivery ? 1 : 0,
        ]);

        // if ($customer) {
        //     $customer->updateLoyalty($totalPrice);
        // }
        if ($customer) {
            $customer->updateLoyalty($totalPrice);
        }

        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            if (!$product) {
                return back()->with('error', 'สินค้า ID ' . $item->product_id . ' ไม่ถูกต้อง');
            }

            if ($product->stock_quantity < $item->quantity) {
                return back()->with('error', 'สต็อกสินค้า ' . optional($product->productItem)->item_name . ' ไม่พอสำหรับการขาย');
            }

            // กำหนดประเภทราคา
            // $priceType = $item->quantity >= 50 ? 'ส่ง' : 'ปลีก';
            // กำหนดประเภทราคา
            // if (in_array($customerType, ['ช่าง', 'ร้านค้า'])) {
            //     $priceType = 'ส่ง';
            //     $price = $product->productItem->wholesale_price;
            // } else {
            //     $priceType = 'ปลีก';
            //     $price = $product->productItem->retail_price;
            // }

            $priceType = $item->price_type ?? 'ปลีก';

            if ($priceType === 'ส่ง') {
                $price = $product->productItem->wholesale_price;
            } else {
                $price = $product->productItem->retail_price;
            }
            // ใช้ราคาที่คำนวณใหม่
            $itemTotal = $price * $item->quantity;
            $totalPriceWithVat = $itemTotal * 1.07;


            // $totalPrice = $price * $item->quantity;
            // $totalPriceWithVat = $totalPrice * 1.07;

            OrderDetail::create([
                'orders_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $price,
                // ✅ ต้องใช้ price ใหม่
                'price_type' => $priceType,
                'total_price' => $itemTotal,
                'total_price_with_vat' => $totalPriceWithVat,
            ]);
            $product->decrement('stock_quantity', $item->quantity);

            // เพิ่มบันทึกการเคลื่อนไหวสต็อก   เออเร่อเอาอันนี้ออก
            StockMovement::create([
                'product_id' => $product->id,
                'quantity' => $item->quantity,
                'movement_type' => 'out',
                'note' => 'ขายสินค้า ออเดอร์ #' . $order->id,
            ]);



        }


        Cart::where('session_id', $sessionId)->delete();

        $message = $isDelivery ? 'สั่งซื้อสำเร็จ (รอตรวจสอบการจัดส่ง)' : 'สั่งซื้อสำเร็จ';
        return redirect()->route('home')->with('success', $message);
    }


    public function checkCustomer(Request $request)
    {
        $phone = $request->phone;
        $customer = Customer::where('phone', $phone)->first();

        // if ($customer) {
        //     return response()->json([
        //         'success' => true,
        //         'customer' => $customer
        //     ]);
        // }
        if ($customer) {
            return response()->json([
                'success' => true,
                'customer' => $customer,
                'can_use_wholesale' => $customer->canUseWholesale()
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function show()
    {
        $sessionId = session()->getId();
        $cartItems = Cart::with('product.productItem')->where('session_id', $sessionId)->get();

        $cart = [];
        foreach ($cartItems as $item) {

            $cart[$item->product_id] = [
                'name' => $item->product->productItem->item_name ?? '',
                'price' => $item->unit_price,
                'qty' => $item->quantity,
                'retail_price' => $item->product->productItem->retail_price,
                'wholesale_price' => $item->product->productItem->wholesale_price,
                'price_type' => $item->price_type ?? 'ปลีก',
            ];
        }

        // ดึงข้อมูลลูกค้า
        $customers = Customer::select(
            'id',
            'name',
            'type',
            'phone',
            'contact_person',
            'address_number',
            'address_building',
            'address_street',
            'address_subdistrict',
            'address_district',
            'address_province',
            'postal_code'
        )
            ->orderBy('name')
            ->get();

        return view('cart', compact('cart', 'customers'));
    }

// public function holdCart(Request $request)
// {
//     $cart = session('cart', []); // ดึงตะกร้าปัจจุบัน
//     dd($cart); // <-- เช็คว่า session มีอะไร

//     if(empty($cart)) {
//         return back()->with('error', 'ไม่มีสินค้าจะพักตะกร้า');
//     }

//     $heldCarts = session('held_carts', []);
//     $cartKey = 'cart_' . (count($heldCarts) + 1);
//     $heldCarts[$cartKey] = $cart;
//     session(['held_carts' => $heldCarts]);

//     // ล้างตะกร้าปัจจุบัน
//     session()->forget('cart');

//     return back()->with('success', 'พักตะกร้าเรียบร้อยแล้ว');
// }


// public function restoreCart($key)
// {
//     $heldCarts = session('held_carts', []);
//     if(isset($heldCarts[$key])){
//         session(['cart' => $heldCarts[$key]]); // กู้กลับไปยังตะกร้าปัจจุบัน
//         unset($heldCarts[$key]); // ลบออกจากตะกร้าที่พักไว้
//         session(['held_carts' => $heldCarts]);

//         return back()->with('success', 'กู้ตะกร้าเรียบร้อย');
//     }

//     return back()->with('error', 'ไม่พบตะกร้านี้');
// }

// public function addToCart(Request $request)
// {
//     $cart = session('cart', []);

//     $id = $request->id;
//     $qty = $request->qty;
//     $product = Product::find($id);

//     $cart[$id] = [
//         'name' => $product->product_name,
//         'price' => $product->price,
//         'qty' => $qty
//     ];

//     session(['cart' => $cart]);

//     return response()->json(['success' => true, 'cart_count' => count($cart)]);
// }
// public function showCart()
// {
//     $cart = session('cart', []);  // ดึง session cart
//     $heldCarts = session('held_carts', []);
//     return view('cart', compact('cart', 'heldCarts'));
// }

// public function hold(Request $request)
// {
//     if (session()->has('current_order')) {
//         session(['hold_order' => session('current_order')]); // เก็บไว้
//         session()->forget('current_order'); // ล้างเพื่อเริ่มใหม่
//     }

//     return response()->json(['status' => 'success']);
// }



// public function resume(Request $request)
// {
//     if (session()->has('hold_order')) {
//         session(['current_order' => session('hold_order')]); // ดึงกลับมา
//         session()->forget('hold_order'); // ลบที่พัก
//     }

//     return response()->json(['status' => 'success']);
// }






}
