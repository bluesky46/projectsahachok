<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers', compact('suppliers'));
    }

    public function show($id)
    {
        $supplier = Supplier::with('productItems')->findOrFail($id);
        return view('showsup', compact('supplier'));
    }


}
