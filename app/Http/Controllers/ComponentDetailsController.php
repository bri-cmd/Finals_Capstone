<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Components\CaseController;
use App\Http\Controllers\Components\GpuController;
use App\Http\Controllers\Components\MoboController;
use App\Models\BuildCategory;
use App\Models\Hardware\M2Slots;
use App\Models\Hardware\Motherboard;
use App\Models\Hardware\PcCase;
use App\Models\Hardware\PcieSlots;
use App\Models\Hardware\SataPorts;
use App\Models\Hardware\UsbPorts;
use Illuminate\Http\Request;


class ComponentDetailsController extends Controller
{
    public function index() {
        $formattedMobos = app(MoboController::class)->getFormattedMobos();
        $formattedGpus = app(GpuController::class)->getFormattedGpus();
        $getFormattedCases = app(CaseController::class)->getFormattedCases();

        // // MERGE COMPONENTS
        $components = collect([
                    ...$formattedMobos,
                    ...$formattedGpus,
                    ...$getFormattedCases,
        ])->sortByDesc('created_at')->values();

        $motherboardSpecs = app(MoboController::class)->getMotherboardSpecs();
        $gpuSpecs = app(GpuController::class)->getGpuSpecs();
        $caseSpecs = app(CaseController::class)->getCaseSpecs();
        
        return view('staff.componentdetails', compact(  'components',
                                                        'motherboardSpecs',
                                                        'gpuSpecs',
                                                        'caseSpecs'
                                                    ));
    }

    public function store () {

    }
}
