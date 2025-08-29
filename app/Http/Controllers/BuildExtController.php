<?php

namespace App\Http\Controllers;

use App\Models\Hardware\Storage;
use Illuminate\Http\Request;

class BuildExtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $components = app(ComponentDetailsController::class)->getAllFormattedComponents();
        $storages = Storage::get()->map(function ($storage) {
                return (object)[
                    'component_type' => strtolower($storage->storage_type), // 'hdd' or 'sdd'
                    'brand'          => $storage->brand,
                    'model'          => $storage->model,
                    'label'          => "{$storage->brand} {$storage->model}",
                    'price'          => $storage->price,
                    'image'          => $storage->image,
                    'buildCategory'  => $storage->buildCategory,
            ];      
        });

        $components = $components->merge($storages);

        return view('buildExt', compact('components'));
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
