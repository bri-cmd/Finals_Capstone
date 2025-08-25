<?php

namespace App\Http\Controllers;

use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    //
    public function index() {
        $lowStockThreshold = 5;
        
        $components = app(ComponentDetailsController::class)->getAllFormattedComponents();
        $components->each(function ($component) use ($lowStockThreshold) {
            $component->status = $component->stock <= $lowStockThreshold ? 'Low' : 'Normal';
        });

        return view('staff.inventory', compact('components'));
    }

    public function search (Request $request) {
        $lowStockThreshold = 5;
        $searchTerm = strtolower($request->input('search'));

        $components = app(ComponentDetailsController::class)->getAllFormattedComponents()->filter(function ($component) use ($searchTerm) {
            return str_contains(strtolower($component['model']), $searchTerm)
                || str_contains(strtolower($component['brand']), $searchTerm);
        });

        $components->each(function ($component) use ($lowStockThreshold) {
            $component->status = $component->stock <= $lowStockThreshold ? 'Low' : 'Normal';
        });

        return view('staff.inventory', array_merge(
            ['components' => $components],
            app(ComponentDetailsController::class)->getAllSpecs()
        ));
    }

    public function stockIn(Request $request) {
        $validated = $request->validate([
            'type' => "required|string",
            'stockInId' => 'required|integer',
            'stock' => 'required|integer|min:1',
        ]);

        $modelMap = config('components');

        if (!array_key_exists($validated['type'], $modelMap)) {
            abort(404, "Unknown component type: {$validated['type']}");
        }

        $model = $modelMap[$validated['type']];
        $component = $model::findOrFail($validated['stockInId']);

        // UPDATE THE STOCK
        $component->stock += $validated['stock'];
        $component->save();

        StockHistory::create([
            'component_id' => $component->id,
            'action' => 'stock-in',
            'quantity_changed' => $validated['stock'],
            'user_id' => Auth::id(),
        ]);

        return back()->with([
            'message' => 'Stock successfully added to ' . ucfirst($validated['type']),
            'type' => 'success',
        ]);
    }

    public function stockOut(Request $request) {
        $validated = $request->validate([
            'type' => "required|string",
            'stockOutId' => 'required|integer',
            'stock' => 'required|integer|min:1',
        ]);

        $modelMap = config('components');

        if (!array_key_exists($validated['type'], $modelMap)) {
            abort(404, "Unknown component type: {$validated['type']}");
        }

        $model = $modelMap[$validated['type']];
        $component = $model::findOrFail($validated['stockOutId']);

        // UPDATE THE STOCK
        $component->stock -= $validated['stock'];
        $component->save();

        StockHistory::create([
            'component_id' => $component->id,
            'action' => 'stock-out',
            'quantity_changed' => $validated['stock'],
            'user_id' => Auth::id(),
        ]);

        return back()->with([
            'message' => 'Stock successfully remove to ' . ucfirst($validated['type']),
            'type' => 'success',
        ]);
    }
}
