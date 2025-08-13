<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Models\BuildCategory;
use App\Models\Hardware\Ram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RamController extends Controller
{
    public function getRamSpecs()
    {
        return [
            'brands' => ['Corsair', 'G.Skill', 'G.Crucial', ],
            'rams' => ['DDR4', 'DDR5'],
            'buildCategories' => BuildCategory::select('id', 'name')->get(),
        ];
    }

    public function getFormattedRams() 
    {
        $rams = Ram::all();

        $rams->each(function ($ram) {
            $ram->speed_display = "{$ram->speed_mhz} MHz";

            $ram->size_display = "{$ram->size_per_module_gb} GB";

            $ram->capacity_display = "{$ram->total_capacity_gb} GB ({$ram->module_count}x{$ram->size_per_module_gb} GB)";

            $ram->price_display = '₱' . number_format($ram->price, 2);

            $ram->component_type = 'ram';
        });

        return $rams;
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
            'ram_type' => 'required|string|max:255',
            'speed_mhz' => 'required|integer|max:255',
            'size_per_module_gb' => 'required|integer|max:255',
            'total_capacity_gb' => 'required|integer|max:255',
            'module_count' => 'required|integer|max:255',
            'is_ecc' => 'required|string|max:255',
            'is_rgb' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:1|max:255',
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'model_3d' => 'nullable|file|mimes:obj,glb,fbx|max:10240',
            'build_category_id' => 'required|exists:build_categories,id',
        ]);

        if ($validated['notes']) {
            $validated['is_rgb'] .= " —{$validated['notes']}";
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

        Ram::create($validated);

        return redirect()->route('staff.componentdetails')->with([
            'message' => 'RAM added',
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
