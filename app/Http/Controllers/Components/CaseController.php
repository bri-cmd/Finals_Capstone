<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Models\Hardware\PcCase;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function getFormattedCases()
    {
        $cases = PcCase::with('formFactors', 'driveBays')->get();

        $cases->each(function ($case) {
            // FORM FACTOR
            $case->form_display = $case->formFactors->map(function ($form) {
                return "{$form->form_factor_support}";
            })->implode('<br>');

            // GPU LENGTH
            $case->max_gpu_length_display = "{$case->max_gpu_length_mm} mm";

            // COOLER HEIGHT
            $case->max_cooler_height_display = "{$case->max_cooler_height_mm} mm";

            // RADIATOR SUPPORT
            $case->radiator_display = $case->radiatorSupports->groupBy('location')->map(function ($group, $location) {
                $sizes = $group->pluck('size_mm')->unique()->sort()->implode(', ');
                return ucfirst($location) . ": {$sizes} mm";
            })->implode('<br>');

            // DRIVE BAYS
            $case->drive_display = $case->driveBays->map(function ($drive) {
                return "{$drive->quantity}x {$drive->size_inch}\" {$drive->drive_type}";
            })->implode('<br>');
            // FAN MOUNTS
            // FRONT USB PORTS
            $case->component_type = 'case';
        });

        return $cases;
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
