<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Models\BuildCategory;
use App\Models\Hardware\M2Slots;
use App\Models\Hardware\Motherboard;
use App\Models\Hardware\PcieSlots;
use App\Models\Hardware\SataPorts;
use App\Models\Hardware\UsbPorts;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class MoboController extends Controller
{
    // FETCHING DATA FOR DROPDOWNS
    public function getMotherboardSpecs()
    {
        return [
            'brands' => Motherboard::select('brand')->distinct()->orderBy('brand')->get(),
            'socketTypes' => Motherboard::select('socket_type')->distinct()->orderBy('socket_type')->get(),
            'chipsets' => Motherboard::select('chipset')->distinct()->orderBy('chipset')->get(),
            'formFactors' => Motherboard::select('form_factor')
                ->distinct()
                ->orderBy('form_factor')
                ->get()
                ->map(function ($item) {
                    $cleaned = trim(explode('(', $item->form_factor)[0]);
                    return (object) ['form_factor' => $cleaned];
                }),
            'ramTypes' => Motherboard::select('ram_type')->distinct()->orderBy('ram_type')->get(),
            'maxRams' => Motherboard::select('max_ram')->distinct()->orderBy('max_ram')->get(),
            'ramSlots' => Motherboard::select('ram_slots')->distinct()->orderBy('ram_slots')->get(),
            'versions' => PcieSlots::select('version')->distinct()->orderBy('version')->get(),
            'laneTypes' => PcieSlots::select('lane_type')->distinct()->orderBy('lane_type')->get(),
            'quantities' => PcieSlots::select('quantity')->distinct()->orderBy('quantity')->get(),
            'lengths' => M2Slots::select('length')->distinct()->orderBy('length')->get(),
            'm2Versions' => M2Slots::select('version')->distinct()->orderBy('version')->get(),
            'm2LaneTypes' => M2Slots::select('lane_type')->distinct()->orderBy('lane_type')->get(),
            'supportSatas' => M2Slots::select('supports_sata')->distinct()->orderBy('supports_sata')->get(),
            'm2quantities' => M2Slots::select('quantity')->distinct()->orderBy('quantity')->get(),
            'sataVersions' => SataPorts::select('version')->distinct()->orderBy('version')->get(),
            'sataQuantities' => SataPorts::select('quantity')->distinct()->orderBy('quantity')->get(), 
            'usbVersions' => UsbPorts::select('version')->distinct()->orderBy('version')->get(),
            'locations' => UsbPorts::select('location')->distinct()->orderBy('location')->get(),
            'types' => UsbPorts::select('type')->distinct()->orderBy('type')->get(),
            'usbQuantities' => UsbPorts::select('quantity')->distinct('quantity')->get(),
            'buildCategories' => BuildCategory::select('id', 'name')->get(),
        ];
    }

    public function getFormattedMobos()
    {
        $mobos = Motherboard::with('pcieSlots', 'm2Slots', 'sataPorts', 'usbPorts')->get();

        // FORMATTING THE DATAS
        $mobos->each(function ($mobo) {
            // PCIe SLOT
            $mobo->pcie_display = $mobo->pcieSlots->map(function ($slot) {
                $display = "{$slot->quantity}x PCIe {$slot->version} {$slot->lane_type}";

                if ($slot->lane_type_notes != null) {
                    $display .= " ({$slot->lane_type_notes})";
                }

                return $display;
            })->implode('<br>');

            // M.2 SLOT
            $mobo->m2_display = $mobo->m2Slots->map(function ($slot) {
                $type = $slot->supports_sata === 'true' ? '/SATA' : '';
                return "{$slot->quantity}x M.2 {$slot->length} (PCIe {$slot->version} {$slot->lane_type}{$type})";
            })->implode('<br>');

            // SATA PORT
            $mobo->sata_display = $mobo->sataPorts->map(function ($slot) {
                return "{$slot->quantity}x SATA {$slot->version}Gb/s";
            })->implode('<br>');

            // USB PORT
            $mobo->usb_display = $mobo->usbPorts->map(function ($port) {
                return "{$port->quantity}x USB {$port->version} {$port->type} ({$port->location})";
            })->implode('<br>');
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
    public function store(Request $request) {
        
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'socket_type' => 'required|string|max:255',
            'chipset' => 'required|string|max:255',
            'form_factor' => 'required|string|max:255',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'ram_type' => 'required|string|max:255',
            'max_ram' => 'required|integer|max:255',
            'ram_slots' => 'required|integer|max:255',
            'max_ram_speed' => 'required|string|max:255',
            'wifi_onboard' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|max:255',
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'model_3d' => 'nullable|file|mimes:obj,glb,fbx|max:10240',
            'build_category_id' => 'required|exists:build_categories,id',
        ]);

        if ($validated['width'] && $validated['height']) {
            $validated['form_factor'] .= " ({$validated['width']}x({$validated['height']}cm)";
        }

        // REMOVING TO AVOID SAVING
        unset($validated['width'], $validated['height']);

        // store the uploaded file in 'public/ids' folder
        // avoid accidental overrites or security issues
        $validated['image'] = $request->file('image');
        $filename = time() . '_' . Str::slug(pathinfo($validated['image']->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $validated['image']->getClientOriginalExtension();
        $validated['image'] =  $validated['image']->storeAs('ids', $filename, 'public');

        // SKIPPING 3D MODEL ON STORING IN DB
        if ($request->hasFile('model_3d')) {
            $model3d = $request->file('model_3d');
            $filename = time() . '_' . Str::slug(pathinfo($model3d->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $model3d->getClientOriginalExtension();
            $validated['model_3d'] = $model3d->storeAs('ids', $filename, 'public');
        } else {
            // If nothing was uploaded, just leave it null or unset it
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
