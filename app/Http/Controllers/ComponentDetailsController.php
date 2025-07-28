<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Components\MoboController;
use App\Models\BuildCategory;
use App\Models\Hardware\M2Slots;
use App\Models\Hardware\Motherboard;
use App\Models\Hardware\PcieSlots;
use App\Models\Hardware\SataPorts;
use App\Models\Hardware\UsbPorts;
use Illuminate\Http\Request;

class ComponentDetailsController extends Controller
{
    public function index() {
        $formattedMobos = app(MoboController::class)->getFormattedMobos();
        $motherboardSpecs = app(MoboController::class)->getMotherboardSpecs();
        
        
        return view('staff.componentdetails', compact(  'formattedMobos',
                                                        'motherboardSpecs',
                                                    ));
    }

    public function store(Request $request) {
        $formFactor = $request->input('form_factor');
        $width = $request->input('width');
        $height = $request->input('height');

        $size = ($width && $height) ? ' ({$width}x{$height}cm)' : '';

        Motherboard::create([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'socket_type' => 'required|string|max:255',
            'chipset' => 'required|string|max:255',
            'form_factor' => $formFactor . $size,
            
        ]);
    }
}
