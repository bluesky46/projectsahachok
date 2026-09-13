<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|unique:units,name'
    //     ]);

    //     Unit::create([
    //         'name' => $request->name
    //     ]);

    //     return redirect()->back()
    //                      ->with('success','เพิ่มหน่วยเรียบร้อย');
    // }

    public function store(Request $request)
{
    $request->validate([
        'name'=>'required|unique:units,name'
    ]);

    $unit = Unit::create([
        'name'=>$request->name
    ]);

    return response()->json([
        'id'=>$unit->id,
        'name'=>$unit->name
    ]);
}


}

