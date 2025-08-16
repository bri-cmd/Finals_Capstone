<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\ComponentDetailsController;
use App\Http\Controllers\Controller;
use App\Models\BuildCategory;
use App\Models\Hardware\Psu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PsuController extends Controller
{
    // FETCHING DATA FRO DROPDOWNS
    public function getPsuSpecs()
    {
        return [
            'brands' => ['EVGA', 'Corsair', 'Seasonic', 'SilverStone', ],
            'efficiency_ratings' => ['80 PLUS Bronze', '80 PLUS Gold', '80 PLUS Titanium', ],
            'modulars' => ['Non-Modular', 'Semi-Modular', 'Fully Modular', ],
            'buildCategories' => BuildCategory::select('id', 'name')->get(),

        ];
    }

    public function getFormattedPsus()
    {
        $psus = Psu::all();

        // FORMATTING THE DATAS
        $psus->each(function ($psu) {
            $psu->price_display = '₱' . number_format($psu->price, 2);

            $psu->component_type = 'psu';
        });

        return $psus;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'wattage' => 'required|integer|max:255',
            'efficiency_rating' => 'required|string|max:255',
            'modular' => 'required|string|max:255',
            'pcie_connectors' => 'required|integer|max:255',
            'sata_connectors' => 'required|integer|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:1|max:255',
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'model_3d' => 'nullable|file|mimes:obj,glb,fbx|max:10240',
            'build_category_id' => 'required|exists:build_categories,id',
        ]);

        // Handle image upload
        $validated['image'] = $request->file('image');
        $filename = time() . '_' . Str::slug(pathinfo($validated['image']->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $validated['image']->getClientOriginalExtension();
        $validated['image'] = $validated['image']->storeAs('product_img', $filename, 'public');

        // Handle 3D model upload
        if ($request->hasFile('model_3d')) {
            $model3d = $request->file('model_3d');
            $filename = time() . '_' . Str::slug(pathinfo($model3d->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $model3d->getClientOriginalExtension();
            $validated['model_3d'] = $model3d->storeAs('product_3d', $filename, 'public');
        } else {
            $validated['model_3d'] = null;
        }

        // dd($request->all()); 

        Psu::create($validated);

        return redirect()->route('staff.componentdetails')->with([
            'message' => 'PSU added',
            'type' => 'success',
        ]); 

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        // $psu = Psu::findOrFail($id);

        // return view('staff.componentdetails.add.psu', compact('psu'));

    }


    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $psu = Psu::findOrFail($id);
    // dd($request->all());


    $psu->update([
        'brand' => $request->brand,
        'model' => $request->model,
        'wattage' => $request->wattage,
        'efficiency_rating' => $request->efficiency_rating,
        'modular' => $request->modular,
        'pcie_connectors' => $request->pcie_connectors,
        'sata_connectors' => $request->sata_connectors,
        'price' => $request->price,
        'stock' => $request->stock,
        'image' => $request->image,
        'model_3d' => $request->model_3d,
        'build_category_id' => $request->build_category_id,
    ]); 

    return redirect()->route('staff.componentdetails')->with([
        'message' => 'PSU updated',
        'type' => 'success',
    ]);

    // try {
    //     // 1. Decode the JSON payload from Alpine
    //     $psuData = json_decode($request->component_json, true);

    //     // 2. Validate Alpine JSON component data
    //     $validatedJson = validator($psuData, [
    //         'brand' => 'required|string|max:255',
    //         'model' => 'required|string|max:255',
    //         'wattage' => 'required|integer|max:255',
    //         'efficiency_rating' => 'required|string|max:255',
    //         'modular' => 'required|string|max:255',
    //         'pcie_connectors' => 'required|integer|max:255',
    //         'sata_connectors' => 'required|integer|max:255',
    //         'price' => 'required|numeric',
    //         'stock' => 'required|integer|min:1|max:255',
    //         // 'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
    //         // 'model_3d' => 'nullable|file|mimes:obj,glb,fbx|max:10240',
    //         'build_category_id' => 'required|exists:build_categories,id',
    //     ])->validate();
        
    //     // dd($request->all());

    //     // 5. Continue updating...
    //     $psu = Psu::findOrFail($id);
    //     $psu->update($validatedJson);

    //     // // Handle image upload
    //     // $validated['image'] = $request->file('image');
    //     // $filename = time() . '_' . Str::slug(pathinfo($validated['image']->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $validated['image']->getClientOriginalExtension();
    //     // $validated['image'] = $validated['image']->storeAs('product_img', $filename, 'public');

    //     // // Handle 3D model upload
    //     // if ($request->hasFile('model_3d')) {
    //     //     $model3d = $request->file('model_3d');
    //     //     $filename = time() . '_' . Str::slug(pathinfo($model3d->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $model3d->getClientOriginalExtension();
    //     //     $validated['model_3d'] = $model3d->storeAs('product_3d', $filename, 'public');
    //     // } else {
    //     //     $validated['model_3d'] = null;
    //     // }

    //     $psu->save();

    //     return redirect()->route('staff.componentdetails')->with([
    //         'message' => 'PSU updated',
    //         'type' => 'success',
    //     ]);
    // } catch (\Illuminate\Validation\ValidationException $e) {
    //     // Catch validation exceptions
    //     dd($e->validator->errors()->all()); // Dump the validation errors to see what went wrong
    // }
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'wattage' => 'required|integer',
            'efficiency_rating' => 'required|string',
            'modular' => 'required|string',
            'pcie_connectors' => 'required|integer',
            'sata_connectors' => 'required|integer',
            'price' => 'required|numeric',
            'build_category_id' => 'required|exists:build_categories,id',
            'stock' => 'required|integer',
            'image' => 'nullable|image',
            'model_3d' => 'nullable|image',
        ]);

        // Handle image upload
        $validated['image'] = $request->file('image');
        $filename = time() . '_' . Str::slug(pathinfo($validated['image']->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $validated['image']->getClientOriginalExtension();
        $validated['image'] = $validated['image']->storeAs('product_img', $filename, 'public');

        // Handle 3D model upload
        if ($request->hasFile('model_3d')) {
            $model3d = $request->file('model_3d');
            $filename = time() . '_' . Str::slug(pathinfo($model3d->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $model3d->getClientOriginalExtension();
            $validated['model_3d'] = $model3d->storeAs('product_3d', $filename, 'public');
        } else {
            $validated['model_3d'] = null;
        }

        if ($request->mode === 'edit' && $request->id) {
            $psu = Psu::findOrFail($request->id);
            $psu->update($validated);
            return redirect()->route('staff.componentdetails')->with([
            'message' => 'PSU updated',
            'type' => 'success',
        ]);
        }

        Psu::create($validated);
        return redirect()->route('staff.componentdetails')->with([
            'message' => 'PSU added',
            'type' => 'success',
        ]);
    }

}
