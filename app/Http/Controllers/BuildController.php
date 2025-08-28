<?php

namespace App\Http\Controllers;

use App\Models\Hardware\Cpu;
use App\Models\Hardware\Storage;
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
        $budget = $request->query('budget');

        // RETRIEVE FILTERS FROM SESSION
        $filters = session('filters', []);
        
        if ($cpuBrand) {
            $components = $components->filter(function ($component) use ($cpuBrand) {
                if ($component->component_type === 'cpu') {
                    return $component->brand === $cpuBrand;
                }

                // LEAVE THE NON-CPU COMPONENTS UNFILTERED
                return true;
            });
        }

        // Fetch storages (HDD/SDD) and treat them as components
        $storages = Storage::when($useCase, function ($query) use ($useCase) {
            $query->whereHas('buildCategory', function ($q) use ($useCase) {
                $q->where('name', $useCase);
            });
        })->get()->map(function ($storage) {
            return (object)[
                'component_type' => strtolower($storage->storage_type), // 'hdd' or 'sdd'
                'brand'          => $storage->brand,
                'model'          => $storage->model,
                'price'          => $storage->price,
                'image'          => $storage->image,
                'buildCategory'  => $storage->buildCategory,
            ];
        });

        $components = $components->merge($storages);

        if ($useCase) {
            $components = $components->filter(function ($component) use ($useCase) {
                return $component->buildCategory->name === $useCase;
            });
        }

        if ($budget) {
            $components = $components->filter(function ($component) use ($budget) {
                return $component->price <= $budget;
            });
        }

        return view('build', compact('components'));
    }

    
}
