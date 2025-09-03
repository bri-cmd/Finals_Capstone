<?php

namespace App\Http\Controllers;

use App\Models\Hardware\Cooler;
use App\Models\Hardware\Cpu;
use App\Models\Hardware\Gpu;
use App\Models\Hardware\Motherboard;
use App\Models\Hardware\PcCase;
use App\Models\Hardware\Psu;
use App\Models\Hardware\Ram;
use App\Models\Hardware\Storage;
use App\Services\CompatibilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BuildController extends Controller
{
    //
    public function index() {
        $components = app(ComponentDetailsController::class)->getAllFormattedComponents();
        $storages = Storage::get()->map(function ($storage) {
                return (object)[
                    'id' => $storage->id,
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

        return view('build', compact('components'));
    }

    public function generateBuild(Request $request) {   
        $category = $request->input('category');
        $cpuBrand = $request->input('cpuBrand');
        $userBudget = $request->input('userBudget');

        // Full path to your script
        $scriptPath = base_path('python_scripts/test_python.py');

        // Build the command with python interpreter
        $escapedCategory = escapeshellarg($category);
        $escapedBrand = escapeshellarg($cpuBrand);
        $escapedBudget = escapeshellarg($userBudget);

        $command = escapeshellcmd("python $scriptPath $escapedCategory $escapedBrand $escapedBudget");

        // Execute and capture output + errors
        $output = shell_exec($command . " 2>&1");

        // Debugging: log output if something goes wrong
        // \Log::info("Python Output: " . $output);

        // Decode JSON safely
        $build = json_decode($output, true);

        if (!$build) {
            return response()->json([
                'error' => 'Python script did not return valid JSON',
                'raw_output' => $output
            ], 500);
        }

        return response()->json($build);
    }

    public function validateBuild(Request $request, CompatibilityService $compat) {
        $cpu = Cpu::find($request->cpu_id);
        $mobo = Motherboard::find($request->motherboard_id);
        $gpu = Gpu::find($request->gpu_id);
        $case = PcCase::find($request->case_id);
        $ram = Ram::find($request->ram_id);
        $psu = Psu::find($request->psu_id);
        $cooler = Cooler::find($request->cooler_id);
        $storage = Storage::find($request->storage_id);

        $issues = [];

        if ($cpu && $mobo && !$compat->isCpuCompatiblewithMotherboard($cpu, $mobo)) {
            $issues[] = "CPU and motherboard socket_type is incompatible.";
        }

        if ($ram && $mobo && !$compat->isRamCompatiblewithMotherboard($ram, $mobo)) {
            $issues[] = "RAM and motherboard ram type is incompatible.";
        }

        if ($gpu && $case && !$compat->isGpuCompatiblewithCase($gpu, $case)) {
            $issues[] = "GPU and Case GPU length is incompatible.";
        }

        if ($cooler && $cpu && $case && !$compat->isCoolerCompatible($cooler, $cpu, $case )) {
            $issues[] = "Cooler, CPU, and Case socket type and height is incompatible.";
        }

        if ($psu && $cpu && $gpu && !$compat->isPsuEnough($psu, $cpu, $gpu )) {
            $issues[] = "PSU, CPU and GPU power is incompatible.";
        }

        if ($case && $mobo && !$compat->isMotherboardCompatiblewithCase($mobo, $case)) {
            $issues[] = "Case and motherboard form factor is incompatible.";
        }

        if ($mobo && $storage && !$compat->isStorageCompatiblewithMotherboard($mobo, $storage)) {
            $issues[] = "Motherboard and Storage interface is incompatible.";
        }

        if (count($issues) > 0) {
            return response()->json([
                'success' => false,
                'errors' => $issues
            ]);
        }

        return response()->json(['success' => true]);
    }
    
}
