<?php

namespace App\Http\Controllers;

use App\Models\Hardware\M2Slots;
use App\Models\Hardware\Motherboard;
use App\Models\Hardware\PcieSlots;
use App\Models\Hardware\SataPorts;
use App\Models\Hardware\UsbPorts;
use Illuminate\Http\Request;

class ComponentDetailsController extends Controller
{
    public function index() {
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
        $lengths = M2Slots::select('length')->distinct()->orderBy('length')->get();
        $m2Versions = M2Slots::select('version')->distinct()->orderBy('version')->get();
        $m2LaneTypes = M2Slots::select('lane_type')->distinct()->orderBy('lane_type')->get();
        $supportSatas = M2Slots::select('supports_sata')->distinct()->orderBy('supports_sata')->get();
        $m2quantities = M2Slots::select('quantity')->distinct()->orderBy('quantity')->get();
        $sataVersions = SataPorts::select('version')->distinct()->orderBy('version')->get();
        $sataQuantities = SataPorts::select('quantity')->distinct()->orderBy('quantity')->get(); 
        $usbVersions = UsbPorts::select('version')->distinct()->orderBy('version')->get();
        $locations = UsbPorts::select('location')->distinct()->orderBy('location')->get();
        $types = UsbPorts::select('type')->distinct()->orderBy('type')->get();
        $usbQuantities = UsbPorts::select('quantity')->distinct('quantity')->get();
        
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
                                                        'quantities', 
                                                        'lengths',
                                                        'm2Versions',
                                                        'm2LaneTypes',
                                                        'supportSatas',
                                                        'm2quantities',
                                                        'sataVersions',
                                                        'sataQuantities',
                                                        'usbVersions',
                                                        'locations',
                                                        'types',
                                                        'usbQuantities'
                                                    ));
    }
}
