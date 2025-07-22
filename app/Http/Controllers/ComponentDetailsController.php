<?php

namespace App\Http\Controllers;

use App\Models\Hardware\Motherboard;
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
        
        return view('staff.componentdetails', compact('mobos'));
    }
}
