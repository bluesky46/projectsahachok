<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreSettingController extends Controller
{
    public function edit()
    {
        $store = \App\Models\StoreSetting::first();

        return view('store-settings', compact('store'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'tax_id' => 'nullable|string|max:13',
        ]);

        $store = \App\Models\StoreSetting::first();

        if ($store) {
            $store->update($validated);
        } else {
            \App\Models\StoreSetting::create($validated);
        }

        return redirect()
            ->route('store-settings.edit')
            ->with('success', 'บันทึกข้อมูลร้านค้าเรียบร้อยแล้ว');
    }
}
