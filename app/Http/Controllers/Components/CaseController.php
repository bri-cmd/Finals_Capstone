<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Models\BuildCategory;
use App\Models\Hardware\PcCase;
use App\Models\Hardware\PcCaseDriveBay;
use App\Models\Hardware\PcCaseFanMount;
use App\Models\Hardware\PcCaseFormFactorSupport;
use App\Models\Hardware\PcCaseFrontUsbPorts;
use App\Models\Hardware\PcCaseRadiatorSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CaseController extends Controller
{
    public function getCaseSpecs()
    {
        return[
            'brands' => PcCase::select('brand')->distinct()->orderBy('brand')->get(),
            'models' => PcCase::select('model')->distinct()->orderBy('model')->get(),
            'form_factor_supports' => PcCaseFormFactorSupport::select('form_factor_support')->distinct()->orderBy('form_factor_support')->get(),
            'locations' => ['Front', 'Top', 'Rear', 'Bottom', 'Side'],
            'drive_types' => ['HDD', 'SDD', 'HDD/SDD'],
            'versions' => ['3.0', '3.2 Gen 1', '3.2 Gen 2', '2.0', '3.1 Gen 2'],
            'connectors' => ['Type-A', 'Type-C', ''],
            'buildCategories' => BuildCategory::select('id', 'name')->get(),
            
        ];
    }

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
            $case->fan_display = $case->fanMounts->groupBy('location')->map(function ($group, $location) {
                $quantities = $group->pluck('quantity')->unique();
                $sizes = $group->pluck('size_mm')->unique()->sort()->implode('/');

                // IF ALL OF THE QUANTITIES ARE THE SAME, DISPLAY ONE
                if($quantities->count() === 1) {
                    $quantity = $quantities->first();
                    return ucfirst(($location) . ": {$quantity}x {$sizes} mm");
                } 

                // OTHERWISE, LIST EACH SIZE WITH ITS QUANTITY
                $detailed = $group->map(function ($mount) {
                    return "{$mount->quantity}x {$mount->size_mm} mm";
                })->implode(' or ');

                return ucfirst($location) . ": {$detailed}";
            })->implode('<br>');

            // FRONT USB PORTS
            $case->usb_display = $case->usbPorts->map(function ($port) {
                return "{$port->quantity}x USB {$port->version} {$port->connector}";
            })->implode('<br>');

            $case->price_display = '₱' . number_format($case->price, 2);


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
        // Validate the request data
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'max_gpu_length_mm'=> 'required|integer|min:1|max:255',
            'max_cooler_height_mm'=> 'required|integer|min:1|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:1|max:255',
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'model_3d' => 'nullable|file|mimes:obj,glb,fbx|max:10240',
            'build_category_id' => 'required|exists:build_categories,id',
        ]);

        // Handle image upload
        $validated['image'] = $request->file('image');
        $filename = time() . '_' . Str::slug(pathinfo($validated['image']->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $validated['image']->getClientOriginalExtension();
        $validated['image'] = $validated['image']->storeAs('product_img', $filename, 'public');

        // Handle 3D model upload
        if ($request->hasFile('model_3d')) {
            $model3d = $request->file('model_3d');
            $filename = time() . '_' . Str::slug(pathinfo($model3d->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $model3d->getClientOriginalExtension();
            $validated['model_3d'] = $model3d->storeAs('product_3d', $filename, 'public');
        } else {
            $validated['model_3d'] = null;
        }

        // dd($validated); 

        $case = PcCase::create($validated);

        // Validate form factor support
        $request->validate([
            'form_factor.*.form_factor_support' => 'required|string|max:255',
        ]);

        $formFactors = $request->input('form_factor');
        // dd($formFactors); 


        // Store form factor
        foreach ($formFactors as $formData) {
            PcCaseFormFactorSupport::create([
                'pc_case_id' => $case->id,
                'form_factor_support' => $formData['form_factor_support']
            ]);
        }

        // Validate radiator support
        $request->validate([
            'radiator_support.*.location' => 'required|string|max:255',
            'radiator_support.*.size_mm' => 'required|integer|max:255',
        ]);

        $radiatorSupports = $request->input('radiator_support');
        // dd($radiatorSupports); 
        

        // Store radiator support
        foreach ($radiatorSupports as $radiatorData) {
            PcCaseRadiatorSupport::create([
                'pc_case_id' => $case->id,
                'location' => $radiatorData['location'],
                'size_mm' => $radiatorData['size_mm'],
            ]);
        }

        // Validate drive bays support
        $request->validate([
            'drive_bays.*.size_inch' => 'required|numeric',
            'drive_bays.*.drive_type' => 'required|string|max:255',
            'drive_bays.*.quantity' => 'required|integer|max:255',
        ]);

        $driveBays = $request->input('drive_bays');
        // dd($driveBays); 

        // Store drive bay
        foreach ($driveBays as $driveData) {
            PcCaseDriveBay::create([
                'pc_case_id' => $case->id,
                'size_inch' => $driveData['size_inch'],
                'drive_type' => $driveData['drive_type'],
                'quantity' => $driveData['quantity'],
            ]);
        }

        // Validate fan mount
        $request->validate([
            'fan_mount.*.location' => 'required|string|max:255',
            'fan_mount.*.size_mm' => 'required|integer|max:255',
            'fan_mount.*.quantity' => 'required|integer|max:255',
        ]);

        $fanMounts = $request->input('fan_mount');
        // dd($fanMounts); 

        // Store fan mount
        foreach ($fanMounts as $fanData) {
            PcCaseFanMount::create([
                'pc_case_id' => $case->id,
                'location' => $fanData['location'],
                'size_mm' => $fanData['size_mm'],
                'quantity' => $fanData['quantity'],
            ]);
        }

        // Validate front usb port
        $request->validate([
            'front_usb.*.version' => 'required|string|max:255',
            'front_usb.*.connector' => 'required|string|max:255',
            'front_usb.*.quantity' => 'required|integer|max:255',
        ]);

        $usbPorts = $request->input('front_usb');

        // Store front usb port
        foreach ($usbPorts as $usbData) {
            PcCaseFrontUsbPorts::create([
                'pc_case_id' => $case->id,
                'version' => $usbData['version'],
                'connector' => $usbData['connector'],
                'quantity' => $usbData['quantity'],
            ]);
        }

        return redirect()->route('staff.componentdetails')->with([
            'message' => 'Case added',
            'type' => 'success',
        ]); 

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
