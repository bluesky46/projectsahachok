<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexCus(Request $request)
    {
        $customers = Customer::all();
        $editCustomer = null;

        if ($request->has('edit_id')) {
            $editCustomer = Customer::find($request->edit_id);
        }

        // สร้าง customer_id ใหม่สำหรับฟอร์ม
        $lastCustomer = Customer::latest('id')->first();
        $number = $lastCustomer ? ((int)substr($lastCustomer->customer_id, 1)) + 1 : 1;
        $newCustomerId = 'C' . str_pad($number, 5, '0', STR_PAD_LEFT); // เช่น C00001

        return view('cus', compact('customers', 'editCustomer', 'newCustomerId'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:ทั่วไป,ร้านค้า,ช่าง',
            'phone' => 'required|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'address_number' => 'nullable|string|max:255',
            'address_building' => 'nullable|string|max:255',
            'address_street' => 'nullable|string|max:255',
            'address_subdistrict' => 'nullable|string|max:255',
            'address_district' => 'nullable|string|max:255',
            'address_province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
        ]);

        // สร้าง customer_id อัตโนมัติ
        $lastCustomer = Customer::latest('id')->first();
        $number = $lastCustomer ? ((int)substr($lastCustomer->customer_id, 1)) + 1 : 1;
        $customerId = 'C' . str_pad($number, 4, '0', STR_PAD_LEFT); // เช่น C0001, C0002

        $validated['customer_id'] = $customerId;

        Customer::create($validated);

        return redirect()->route('customer')->with('success', 'เพิ่มข้อมูลลูกค้าเรียบร้อยแล้ว');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    return redirect()->route('customer', ['edit_id' => $id]);
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'customer_id' => 'required|unique:customers,customer_id,' . $customer->id,
            'name' => 'required|string|max:255',
            'type' => 'required|in:ทั่วไป,ร้านค้า,ช่าง',
            'phone' => 'required|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'address_number' => 'nullable|string|max:255',
            'address_building' => 'nullable|string|max:255',
            'address_street' => 'nullable|string|max:255',
            'address_subdistrict' => 'nullable|string|max:255',
            'address_district' => 'nullable|string|max:255',
            'address_province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
        ]);

        $customer->update($validated);

        return redirect()->route('customer')->with('success', 'แก้ไขข้อมูลลูกค้าเรียบร้อยแล้ว');
    }

    public function checkByPhone(Request $request)
{
    $phone = $request->query('phone');
    $customer = Customer::where('phone', $phone)->first();

    if ($customer) {
        return response()->json(['found' => true, 'type' => $customer->type]);
    }

    return response()->json(['found' => false]);
}



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
{
    $customer->delete();
    return redirect()->route('customer')->with('success', 'ลบข้อมูลลูกค้าเรียบร้อยแล้ว');
}



// public function checkCustomer(Request $request)
// {
//     $phone = $request->query('phone');

//     $found = Customer::where('phone', $phone)->exists();

//     return response()->json(['found' => $found]);
// }

public function checkPhone(Request $request)
{
    $phone = $request->input('phone');

    $customer = Customer::where('phone', $phone)->first();

    return response()->json([
        'found' => $customer ? true : false
    ]);
}

public function viewOrders(Request $request)
{
    $phone = $request->phone;

    // ดึงข้อมูลลูกค้า
    $customer = Customer::where('phone', $phone)->first();

    if (!$customer) {
        return redirect()->back()->with('error', 'ไม่พบลูกค้า');
    }

    // ดึงคำสั่งซื้อจากเบอร์
    $orders = Order::with(['orderDetails.product'])
        ->where('customer_phone', $phone)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.customer-orders', compact('customer', 'orders'));
}


}
