<?php

namespace App\Http\Controllers\Components;
 
use App\Http\Controllers\Controller;
use App\Models\BuildCategory;
use App\Models\Hardware\Cooler;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CoolerController extends Controller
{
    //
    public function getCoolerSpecs()
    {
        return[
            'brands' => ['Intel', 'Cooler Master', 'be quiet!', 'DeepCool', 'Noctua'],
            'cooler_types' => ['Air Cooler', 'Liquid Cooler'],
            'socket_compatibilities' => ['LGA 1700', 'AM5', 'AM4'],
            'buildCategories' => BuildCategory::select('id', 'name')->get(),
        ];
    }

    public function getFormattedCoolers()
    {
        $coolers = Cooler::all();

        $coolers->each(function ($cooler) {
            $cooler->component_type = 'cooler';

        });
        return $coolers;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'cooler_type' => 'required|string|max:255',
            'socket_compatibility' => 'required|array',
            'socket_compatibility.*' => 'required|string|max:255',
            'max_tdp' => 'required|integer|min:1',
            'radiator_size_mm' => 'nullable|integer|min:1',
            'fan_count' => 'required|integer|min:1',
            'height_mm' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:1|max:255',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'model_3d' => 'nullable|file|mimes:glb|max:10240',
            'build_category_id' => 'required|exists:build_categories,id',
        ]);

        $validated['socket_compatibility'] = implode(',', $validated['socket_compatibility']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($validated['image']->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $validated['image']->getClientOriginalExtension();
            $validated['image'] = $validated['image']->storeAs('cooler', $filename, 'public');
        } else {
            $validated['image'] = null;
        }


        // Handle 3D model upload
        if ($request->hasFile('model_3d')) {
            $model3d = $request->file('model_3d');
            $filename = time() . '_' . Str::slug(pathinfo($model3d->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $model3d->getClientOriginalExtension();
            $validated['model_3d'] = $model3d->storeAs('cooler', $filename, 'public');
        } else {
            $validated['model_3d'] = null;
        }

        Cooler::create($validated);

        return redirect()->route('staff.componentdetails')->with([
            'message' => 'Cooler added',
            'type' => 'success',
        ]); 
    }
}
