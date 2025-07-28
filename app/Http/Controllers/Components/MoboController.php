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
            'buildCategories' => BuildCategory::select('name')->distinct('name')->get(),
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
    public function store(Request $request)
    {
        //
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
