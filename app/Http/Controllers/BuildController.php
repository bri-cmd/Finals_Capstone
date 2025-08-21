<?php

namespace App\Http\Controllers;

use App\Models\Hardware\Cpu;
use Illuminate\Http\Request;

class BuildController extends Controller
{
    //
    public function index() {
        $components = app(ComponentDetailsController::class)->getAllFormattedComponents();

        return view('build', compact('components'));
    }

    public function generate(Request $request) {   
        $components = app(ComponentDetailsController::class)->getAllFormattedComponents();
        
        $cpuBrand = $request->query('cpu');
        $useCase = $request->query('useCase');
        // $budget = $request->query('budget');

        // RETRIEVE FILTERS FROM SESSION
        $filters = session('filters', []);

        if ($cpuBrand) {
            $components = $components->filter(function ($component) use ($cpuBrand) {
                return $component->component_type === 'cpu' && $component->brand === $cpuBrand;
            });
        }

        if ($useCase) {
            $components = $components->filter(function ($component) use ($useCase) {
                return $component->buildCategory->name === $useCase;
            });
        }

        // if ($budget) {
        //     $components = $components->filter(function ($component) use ($budget) {
        //         return $component->price <= $budget;
        //     });
        // }

        return view('build', compact('components'));
    }

    public function amd() {
        $cpu = Cpu::where('brand', 'AMD')->get();
        $components = app(ComponentDetailsController::class)->getAllFormattedComponents();

        // QUERY THAT FETCHES THE CPU BRAND THAT IS AMD
        return view('build', compact('cpu','components'));
    }

    public function intel() {
        $cpu = Cpu::where('brand', 'Intel')->get();
        $components = app(ComponentDetailsController::class)->getAllFormattedComponents();

        // QUERY THAT FETCHES THE CPU BRAND THAT IS AMD
        return view('build', compact('cpu','components'));
    }
}
