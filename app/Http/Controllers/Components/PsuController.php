<?php

namespace App\Http\Controllers\Components;

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
            'wattage' => 'required|string|max:255',
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

        // dd($validated); 

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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
