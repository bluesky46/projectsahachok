<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class RiderController extends Controller
{
    // public function dashboard()
    // {
    //     $orders = Order::where('status','pending')->get();
    //     return view('rider.dashboard', compact('orders'));
    // }
    public function dashboard()
{
    $orders = Order::where('status','pending_delivery')->get();
    return view('rider.dashboard', compact('orders'));
}

    public function showOrder($id)
    {

        $order = Order::with('orderDetails.product')->findOrFail($id);
        // dd($order->orderDetails);
        return view('rider.order-detail', compact('order'));
    }


public function completeOrder(Request $request, $id)
{
    $request->validate([
        'delivery_image' => 'required|file|mimes:jpg,jpeg,png|max:5120'
    ]);

    $order = Order::findOrFail($id);

    if ($request->hasFile('delivery_image')) {
        $imagePath = $request->file('delivery_image')
                            ->store('delivery_proofs', 'public');

        $order->delivery_image = $imagePath;
    }

    $order->status = 'completed';
    $order->save();

    return redirect()->route('rider.dashboard')
                     ->with('success','จัดส่งเรียบร้อยแล้ว');
}

}
