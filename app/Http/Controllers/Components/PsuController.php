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
            'brands' => Psu::select('brand')->distinct()->orderBy('brand')->get(),
            'ratings' => ['80 PLUS Bronze', '80 PLUS Gold', '80 PLUS Titanium', ],
            'modulars' => ['No', 'Semi-Modular', 'Fully Modular', ],
            'pcies' => ['2x 8-pin (6+2)', '4× 8-pin (6+2)', '8× 8-pin (6+2)', ],
            'satas' => ['6x SATA', '10× SATA', '12× SATA', ],
            'buildCategories' => BuildCategory::select('id', 'name')->get(),

        ];
    }

    public function getFormattedPsus()
    {
        $psus = Psu::all();

        // FORMATTING THE DATAS
        $psus->each(function ($psu) {
            $psu->wattage_display = "{$psu->wattage} W continous";
            
            $modularity = strtolower($psu->modular) === 'no' ? ' ' : 'modular';
            $psu->pcie_display = "{$psu->pcie_connectors} {$modularity}";
            $psu->sata_display = "{$psu->sata_connectors} {$modularity}";

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
            'efficiency_percent' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'modular' => 'required|string|max:255',
            'pcie_connectors' => 'required|string|max:255',
            'sata_connectors' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:1|max:255',
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'model_3d' => 'nullable|file|mimes:obj,glb,fbx|max:10240',
            'build_category_id' => 'required|exists:build_categories,id',
        ]);

        if ($validated['notes']) {
            $validated['efficiency_rating'] .= " (up to {$validated['efficiency_percent']}% efficiency {$validated['notes']})";
        } else {
            $validated['efficiency_rating'] .= " (up to {$validated['efficiency_percent']} efficiency)";
        }

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
