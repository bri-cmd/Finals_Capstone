<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Components\CaseController;
use App\Http\Controllers\Components\GpuController;
use App\Http\Controllers\Components\MoboController;
use App\Http\Controllers\Components\PsuController;
use App\Http\Controllers\Components\RamController;



class ComponentDetailsController extends Controller
{
    public function index() {
        $formattedMobos = app(MoboController::class)->getFormattedMobos();
        $formattedGpus = app(GpuController::class)->getFormattedGpus();
        $getFormattedCases = app(CaseController::class)->getFormattedCases();
        $getFormattedPsus = app(PsuController::class)->getFormattedPsus();
        $getFormattedRams = app(RamController::class)->getFormattedRams();

        // MERGE COMPONENTS
        $components = collect([
                    ...$formattedMobos,
                    ...$formattedGpus,
                    ...$getFormattedCases,
                    ...$getFormattedPsus,
                    ...$getFormattedRams,
        ])->sortByDesc('created_at')->values();

        $motherboardSpecs = app(MoboController::class)->getMotherboardSpecs();
        $gpuSpecs = app(GpuController::class)->getGpuSpecs();
        $caseSpecs = app(CaseController::class)->getCaseSpecs();
        $psuSpecs = app(PsuController::class)->getPsuSpecs();
        
        return view('staff.componentdetails', compact(  'components',
                                                        'motherboardSpecs',
                                                        'gpuSpecs',
                                                        'caseSpecs',
                                                        'psuSpecs'
                                                    ));
    }

    public function store () {

    }
}
