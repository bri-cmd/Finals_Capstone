<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Models\BuildCategory;
use App\Models\Hardware\MoboM2Slots;
use App\Models\Hardware\MoboPcieSlot;
use App\Models\Hardware\MoboSataPorts;
use App\Models\Hardware\MoboUsbPorts;
use App\Models\Hardware\Motherboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\GoogleDriveUploader;
use Illuminate\Support\Facades\Config;

class MoboController extends Controller
{
    // FETCHING DATA FOR DROPDOWNS
    public function getMotherboardSpecs()
    {
        return [
            'buildCategories' => BuildCategory::select('id', 'name')->get(),
            'brands' => ['ASUS', 'MSI', 'ASRock', ],
            'socket_types' => ['LGA 1700', 'AM4', ],
            'chipsets' => ['Intel H610', 'AMD B550', 'AMD B450', 'Intel Z790'],
            'form_factors' => ['Micro-ATX', 'ATX', 'Mini-ITX', ],
            'ram_types' => ['DDR4', 'DDR5', ],
            'wifi_onboards' => ['Yes', 'No', ],
        ];
    }

    public function getFormattedMobos()
    {
        $mobos = Motherboard::all();

        // FORMATTING THE DATAS
        $mobos->each(function ($mobo) {
            if($mobo->wifi_onboard === 'true'){
                $mobo->wifi_display = 'Yes';
            } else {
                $mobo->wifi_display = 'No';
            }
            
            $mobo->price_display = '₱' . number_format($mobo->price, 2);
            $mobo->component_type = 'motherboard';
            
            
        });

        return $mobos;
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
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'socket_type' => 'required|string|max:255',
            'chipset' => 'required|string|max:255',
            'form_factor' => 'required|string|max:255',
            'ram_type' => 'required|string|max:255',
            'max_ram' => 'required|integer|max:255',
            'ram_slots' => 'required|string|max:255',
            'max_ram_speed' => 'required|integer|max:255',
            'pcie_slots' => 'required|integer|max:255',
            'm2_slots' => 'required|integer|max:255',
            'sata_ports' => 'required|integer|max:255',
            'usb_ports' => 'required|integer|max:255',
            'wifi_onboard' => 'required|string|max:255',
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

        Motherboard::create($validated);
    
        return redirect()->route('staff.componentdetails')->with([
            'message' => 'Motherboard added',
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
        $mobo = Motherboard::findOrFail($id);

        $mobo->update([
            'build_category_id' => $request->build_category_id,
            'brand' => $request->brand,
            'model' => $request->model,
            'socket_type' => $request->socket_type,
            'chipset' => $request->chipset,
            'form_factor' => $request->form_factor,
            'ram_type' => $request->ram_type,
            'max_ram' => $request->max_ram,
            'ram_slots' => $request->ram_slots,
            'max_ram_speed' => $request->max_ram_speed,
            'pcie_slots' => $request->pcie_slots,
            'm2_slots' => $request->m2_slots,
            'sata_ports' => $request->sata_ports,
            'usb_ports' => $request->usb_ports,
            'wifi_onboard' => $request->wifi_onboard,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('staff.componentdetails')->with([
            'message' => 'Motherboard updated',
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
