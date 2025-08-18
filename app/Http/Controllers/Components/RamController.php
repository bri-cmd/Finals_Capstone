<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Models\BuildCategory;
use App\Models\Hardware\Ram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\GoogleDriveUploader;
use Illuminate\Support\Facades\Config;

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
            $ram->ecc_display = ($ram->is_ecc === 'false') ? 'No' : 'Yes';
            $ram->rgb_display = ($ram->is_rgb === 'false') ? 'No' : 'Yes';

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
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:1|max:255',
            'image' => 'nullable|array',
            'image.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'model_3d' => 'nullable|file|mimes:glb|max:10240',
            'build_category_id' => 'required|exists:build_categories,id',
        ]);

        // Handle image upload
        $uploader = new GoogleDriveUploader();
        $filenames = [];

        if ($request->hasFile('image')) {
            $folderMap = Config::get('googlefolders');
            $type = $request->input('component_type');

            $folderId = $folderMap[$type] ?? Config::get('filesystems.disks.google.folderId');
            // $folderId = '1zm5zcTZCOAMAen1803mWMg1s7r1mcrTj';

            foreach ($request->file('image') as $image) {
                $fileId = $uploader->upload($image, $folderId);
                $filenames[] = $fileId;
            }

            $validated['image'] = $filenames;
        } else {
            $validated['image'] = null;
        }

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
        $ram = Ram::findOrFail($id);

        $ram->update([
            'build_category_id' => $request->build_category_id,
            'brand' => $request->brand,
            'model' => $request->model,
            'ram_type' => $request->ram_type,
            'speed_mhz' => $request->speed_mhz,
            'size_per_module_gb' => $request->size_per_module_gb,
            'total_capacity_gb' => $request->total_capacity_gb,
            'module_count' => $request->module_count,
            'is_ecc' => $request->is_ecc,
            'is_rgb' => $request->is_rgb,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('staff.componentdetails')->with([
            'message' => 'RAM updated',
            'type' => 'success',
        ]); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 
    }
}
