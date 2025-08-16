<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Models\BuildCategory;
use App\Models\Hardware\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage as StorageFacade;

class StorageController extends Controller
{
    public function getStorageSpecs()
    {
        return [
            'brands' => ['Kingston', 'Western Digital', 'Samsung', 'Seagate', ],
            'storage_types' => ['SSD', 'HDD', ],
            'buildCategories' => BuildCategory::select('id', 'name')->get(),

        ];  
    }

    public function getFormattedStorages()
    {
        $storages = Storage::all();

        $storages->each(function ($storage) {
            $storage->capacity_display = "{$storage->capacity_gb} GB";
            $storage->read_display = "Up to {$storage->read_speed_mbps} MB/s";
            $storage->write_display = "Up to {$storage->write_speed_mbps} MB/s";
            $storage->price_display = '₱' . number_format($storage->price, 2);

            $storage->component_type = 'storage';
        });

        return $storages;
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
            'storage_type' => 'required|string|max:255',
            'interface' => 'required|string|max:255',
            'capacity_gb' => 'required|integer|max:255',
            'form_factor' => 'required|string|max:255',
            'read_speed_mbps' => 'required|integer|max:255',
            'write_speed_mbps' => 'required|integer|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:1|max:255',
            'image.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'model_3d' => 'nullable|file|mimes:obj,glb,fbx|max:10240',
            'build_category_id' => 'required|exists:build_categories,id',
        ]);

        // Handle image upload
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();

        //     // Upload to Google Drive
        //     Storage::disk('google')->put($filename, file_get_contents($image));

        //     // Optionally store the filename or a placeholder path
        //     $validated['image'] = $filename;
        // }
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
                StorageFacade::disk('google')->put($filename, file_get_contents($image));
                // Optionally store filenames in an array
            }
        }


        // Handle 3D model upload
        if ($request->hasFile('model_3d')) {
            $model3d = $request->file('model_3d');
            $filename = time() . '_' . Str::slug(pathinfo($model3d->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $model3d->getClientOriginalExtension();
            $validated['model_3d'] = $model3d->storeAs('product_3d', $filename, 'public');
        } else {
            $validated['model_3d'] = null;
        }

        // dd($request->all());

        Storage::create($validated);

        return redirect()->route('staff.componentdetails')->with([
            'message' => 'Storage added',
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
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $storage = Storage::findOrFail($id);

        $storage->update([
            'build_category_id' => $request->build_category_id,
            'brand' => $request->brand,
            'model' => $request->model,
            'storage_type' => $request->storage_type,
            'interface' => $request->interface,
            'capacity_gb' => $request->capacity_gb,
            'form_factor' => $request->form_factor,
            'read_speed_mbps' => $request->read_speed_mbps,
            'write_speed_mbps' => $request->write_speed_mbps,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $request->image,
            'model_3d' => $request->model_3d,
        ]);
        // dd($request->all());


        return redirect()->route('staff.componentdetails')->with([
            'message' => 'Storage updated',
            'type' => 'success',
        ]); 

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
