<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Components\CaseController;
use App\Http\Controllers\Components\CpuController;
use App\Http\Controllers\Components\GpuController;
use App\Http\Controllers\Components\MoboController;
use App\Http\Controllers\Components\PsuController;
use App\Http\Controllers\Components\RamController;
use App\Http\Controllers\Components\StorageController;

class ComponentDetailsController extends Controller
{
    public function index() {
        $formattedMobos = app(MoboController::class)->getFormattedMobos();
        $formattedGpus = app(GpuController::class)->getFormattedGpus();
        $getFormattedCases = app(CaseController::class)->getFormattedCases();
        $getFormattedPsus = app(PsuController::class)->getFormattedPsus();
        $getFormattedRams = app(RamController::class)->getFormattedRams();
        $getFormattedStorages = app(StorageController::class)->getFormattedStorages();
        $getFormattedCpus = app(CpuController::class)->getFormattedCpus();

        // MERGE COMPONENTS
        $components = collect([
                    ...$formattedMobos,
                    ...$formattedGpus,
                    ...$getFormattedCases,
                    ...$getFormattedPsus,
                    ...$getFormattedRams,
                    ...$getFormattedStorages,
                    ...$getFormattedCpus,
        ])->sortByDesc('created_at')->values();

        $motherboardSpecs = app(MoboController::class)->getMotherboardSpecs();
        $gpuSpecs = app(GpuController::class)->getGpuSpecs();
        $caseSpecs = app(CaseController::class)->getCaseSpecs();
        $psuSpecs = app(PsuController::class)->getPsuSpecs();
        $ramSpecs = app(RamController::class)->getRamSpecs();
        $storageSpecs = app(StorageController::class)->getStorageSpecs();
        $cpuSpecs = app(CpuController::class)->getCpuSpecs();
        
        return view('staff.componentdetails', compact(  'components',
                                                        'motherboardSpecs',
                                                        'gpuSpecs',
                                                        'caseSpecs',
                                                        'psuSpecs',
                                                        'ramSpecs',
                                                        'storageSpecs',
                                                        'cpuSpecs',
                                                    ));
    }

    public function store () {

    }
}
