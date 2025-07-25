<?php

namespace App\Http\Controllers;

use App\Models\Hardware\Motherboard;
use App\Models\Hardware\PcieSlots;
use Illuminate\Http\Request;

class ComponentDetailsController extends Controller
{
    public function index() {
        $mobos = Motherboard::with('pcieSlots', 'm2Slots', 'sataPorts', 'usbPorts')->get();

        // FORMATTING THE DATAS
        $mobos->each(function ($mobo) {
            // PCIe SLOT
            $mobo->pcie_display = $mobo->pcieSlots->map(function ($slot) {
                return "{$slot->quantity}x PCIe {$slot->version} {$slot->lane_type} ({$slot->lane_type_notes})";
            })->implode(', ');

            // M.2 SLOT
            $mobo->m2_display = $mobo->m2Slots->map(function ($slot) {
                $type = $slot->supports_stat === 'Yes' ? 'PCIe & SATA' : 'PCIE';
                return "{$slot->quantity}x M.2 {$slot->length} ({$type} {$slot->version} {$slot->lane_type})";
            })->implode(', ');

            // SATA PORT
            $mobo->sata_display = $mobo->sataPorts->map(function ($slot) {
                return "{$slot->quantity}x SATA {$slot->version}Gb/s";
            })->implode(', ');

            // USB PORT
            $mobo->usb_display = $mobo->usbPorts->map(function ($port) {
                $label = "{$port->quantity}x USB {$port->version}";

                $label .= " {$port->type}";

                if ($port->location === 'header') {
                    $label .= " ({$port->location})";
                } else {
                    $label .= " ({$port->location})";
                }

                return $label;
            })->implode(', ');
        });

        $brands = Motherboard::select('brand')->distinct()->orderBy('brand')->get();
        $socketTypes = Motherboard::select('socket_type')->distinct()->orderBy('socket_type')->get();
        $chipsets = Motherboard::select('chipset')->distinct()->orderBy('chipset')->get();
        $formFactors = Motherboard::select('form_factor')
            ->distinct()
            ->orderBy('form_factor')
            ->get()
            ->map(function ($item) {
                $cleaned = trim(explode('(', $item->form_factor)[0]);
                return (object) ['form_factor' => $cleaned];
            });
        $ramTypes = Motherboard::select('ram_type')->distinct()->orderBy('ram_type')->get();
        $maxRams = Motherboard::select('max_ram')->distinct()->orderBy('max_ram')->get();
        $ramSlots = Motherboard::select('ram_slots')->distinct()->orderBy('ram_slots')->get();
        $versions = PcieSlots::select('version')->distinct()->orderBy('version')->get();
        $laneTypes = PcieSlots::select('lane_type')->distinct()->orderBy('lane_type')->get();
        $quantities = PcieSlots::select('quantity')->distinct()->orderBy('quantity')->get();
        
        return view('staff.componentdetails', compact(  'mobos',
                                                        'brands',
                                                        'socketTypes',
                                                        'chipsets',
                                                        'formFactors',
                                                        'ramTypes', 
                                                        'maxRams', 
                                                        'ramSlots', 
                                                        'versions', 
                                                        'laneTypes',
                                                        'quantities', ));
    }
}
