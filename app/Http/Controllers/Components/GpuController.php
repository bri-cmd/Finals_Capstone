<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Models\Hardware\Gpu;
use Illuminate\Http\Request;

class GpuController extends Controller
{
    public function getGpuSpecs() 
    {

    }

    public function getFormattedGpus() 
    {
        $gpus = Gpu::all();
        
        $gpus->each(function ($gpu) {
            $gpu->component_type = 'motherboard';
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
