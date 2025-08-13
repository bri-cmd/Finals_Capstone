<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Models\BuildCategory;
use App\Models\Hardware\Cpu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CpuController extends Controller
{
    public function getCpuSpecs()
    {
        return [
            'brands' => ['Intel', 'AMD', ],
            'socket_types' => ['LGA 1700', 'AM4', 'AM5', ],
            'buildCategories' => BuildCategory::select('id', 'name')->get(),

        ];
    }

    public function getFormattedCpus() 
    {
        $cpus = Cpu::all();

        $cpus->each(function ($cpu) {
            $cpu->base_display = "{$cpu->base_clock} GHz";
            $cpu->boost_display = "Up to {$cpu->boost_clock} GHz";
            $cpu->tdp_display = "{$cpu->tdp} W";
            $cpu->price_display = '₱' . number_format($cpu->price, 2);
            $cpu->component_type = 'cpu';
        });

        return $cpus;
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
            'socket_type' => 'required|string|max:255',
            'cores' => 'required|integer|max:255',
            'threads' => 'required|integer|max:255',
            'base_clock' => 'required|numeric',
            'boost_clock' => 'required|numeric',
            'tdp' => 'required|integer|max:255',
            'integrated_graphics' => 'required|string|max:255',
            'generation' => 'required|string|max:255',
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

        Cpu::create($validated);

        return redirect()->route('staff.componentdetails')->with([
            'message' => 'CPU added',
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
