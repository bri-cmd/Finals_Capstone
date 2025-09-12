<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    //
    public function index() {
        $suppliers = Supplier::paginate(6);

        return view('staff.supplier', compact('suppliers'));
    }

    public function storeSupplier(Request $request) {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        $validate['is_active'] = true;

        Supplier::create($validate);

        return redirect()->route('staff.supplier')->with([
            'message' => 'Supplier added',
            'type' => 'success',
        ]); 
    }

    public function storeBrand(Request $request) {
        $validate = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
        ]);

        Brand::create($validate);

        return redirect()->route('staff.supplier')->with([
            'message' => 'Brand added',
            'type' => 'success',
        ]); 
    }
}
