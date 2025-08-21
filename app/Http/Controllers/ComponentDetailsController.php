<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Components\CaseController;
use App\Http\Controllers\Components\CpuController;
use App\Http\Controllers\Components\GpuController;
use App\Http\Controllers\Components\MoboController;
use App\Http\Controllers\Components\PsuController;
use App\Http\Controllers\Components\RamController;
use App\Http\Controllers\Components\StorageController;
use Illuminate\Http\Request;
use App\Services\GoogleDriveUploader;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class ComponentDetailsController extends Controller
{
    public function getAllFormattedComponents()
    {
        return collect([
            ...app(MoboController::class)->getFormattedMobos(),
            ...app(GpuController::class)->getFormattedGpus(),
            ...app(CaseController::class)->getFormattedCases(),
            ...app(PsuController::class)->getFormattedPsus(),
            ...app(RamController::class)->getFormattedRams(),
            ...app(StorageController::class)->getFormattedStorages(),
            ...app(CpuController::class)->getFormattedCpus(),
        ])->sortByDesc('created_at')->values();
    }

    private function getAllSpecs()
    {
        return [
            'moboSpecs' => app(MoboController::class)->getMotherboardSpecs(),
            'gpuSpecs' => app(GpuController::class)->getGpuSpecs(),
            'caseSpecs' => app(CaseController::class)->getCaseSpecs(),
            'psuSpecs' => app(PsuController::class)->getPsuSpecs(),
            'ramSpecs' => app(RamController::class)->getRamSpecs(),
            'storageSpecs' => app(StorageController::class)->getStorageSpecs(),
            'cpuSpecs' => app(CpuController::class)->getCpuSpecs(),
        ];
    }

    public function index() {
        $components = $this->getAllFormattedComponents();
        
        return view('staff.componentdetails', array_merge(
            ['components' => $components],
            $this->getAllSpecs()
        ));
    }

    public function delete (string $type, string $id) {
        $modelMap = config('components'); // FOUND IN CONFIG FILE

        if (!array_key_exists($type, $modelMap)) {
            abort(404, "Unknown component type: {$type}");
        }   

        $model = $modelMap[$type];
        $component = $model::findOrFail($id);

        // DELETE PRODUCT IMAGE
        if ($component->image) {
            FacadesStorage::disk('public')->delete($component->image);
        }

        // DELETE 3D MODEL
        if ($component->model_3d) {
            FacadesStorage::disk('public')->delete($component->model_3d);
        }

        $component->delete();

        return back()->with([
            'message' => ucfirst($type) . ' has been deleted.',
            'type' => 'success',
        ]);
    }

    public function search (Request $request) {
        $searchTerm = strtolower($request->input('search'));

        $components = $this->getAllFormattedComponents()->filter(function ($component) use ($searchTerm) {
            return str_contains(strtolower($component['model']), $searchTerm)
                || str_contains(strtolower($component['brand']), $searchTerm);
        });

        return view('staff.componentdetails', array_merge(
            ['components' => $components],
            $this->getAllSpecs()
        ));
    }
}
