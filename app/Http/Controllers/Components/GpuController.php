<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Models\BuildCategory;
use App\Models\Hardware\Gpu;
use Illuminate\Http\Request;

class GpuController extends Controller
{
    public function getGpuSpecs() 
    {
        return [
            'brands' => Gpu::select('brand')->distinct()->orderBy('brand')->get(),
            'vram_gbs' => ['GDDR5', 'GDDR6', 'GDDR6X'],
            'pcie_interfaces' => Gpu::select('pcie_interface')->distinct()->orderBy('pcie_interface')->get(),
            'connectors_requireds' => Gpu::select('connectors_required')->distinct()->orderBy('connectors_required')->get(),
            'buildCategories' => BuildCategory::select('id', 'name')->get(),
        ];
    }

    public function getFormattedGpus() 
    {
        $gpus = Gpu::all();
        
        $gpus->each(function ($gpu) {
            $gpu->component_type = 'gpu';
        });

        return $gpus;
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
