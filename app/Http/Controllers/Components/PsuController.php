<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\ComponentDetailsController;
use App\Http\Controllers\Controller;
use App\Models\BuildCategory;
use App\Models\Hardware\Psu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\GoogleDriveUploader;
use Illuminate\Support\Facades\Config;

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
            'build_category_id' => $request->build_category_id,
        ]); 

        return redirect()->route('staff.componentdetails')->with([
            'message' => 'PSU updated',
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
