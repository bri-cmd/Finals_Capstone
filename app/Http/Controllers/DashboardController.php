<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Exception;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Total orders
            $totalOrders = Order::count();

            // Pending orders
            $pendingOrders = Order::where('status', 'pending')->count();

            // Revenue (sum of all completed order totals) - uses 'total' column as in your CheckoutController
            $revenue = (float) Order::where('status', 'completed')->sum('total');

            // Low stock items:
            // We don't assume a Product model exists. Instead, check config('components') for models
            $lowStockItems = 0;
            $models = config('components', []);
            if (!empty($models) && is_array($models)) {
                foreach ($models as $modelClass) {
                    if (is_string($modelClass) && class_exists($modelClass)) {
                        try {
                            // attempt to count items with 'stock' < 10; if the model doesn't have 'stock' it will throw and we skip it
                            $lowStockItems += (int) $modelClass::where('stock', '<', 10)->count();
                        } catch (Exception $exModel) {
                            // ignore models that don't support 'stock' or have other issues
                            Log::warning("Dashboard: skipped {$modelClass} when calculating low stock: " . $exModel->getMessage());
                            continue;
                        }
                    }
                }
            }

            // Recent orders (latest 5) — load 'user' relation if available
            $recentOrders = Order::with(['user'])->latest()->take(5)->get();

            // Provide a $order->customer->name object for backward-compatibility with the blade
            foreach ($recentOrders as $order) {
                $customerName = 'N/A';
                try {
                    if ($order->relationLoaded('user') && $order->user) {
                        $u = $order->user;
                        $customerName = $u->name ?? trim(($u->first_name ?? '') . ' ' . ($u->last_name ?? '')) ?: ($u->email ?? 'N/A');
                    }
                } catch (Exception $e) {
                    Log::warning("Dashboard: error resolving customer name for order {$order->id}: " . $e->getMessage());
                }
                $order->customer = (object) ['name' => $customerName];
            }

            // Sales data for chart (last 6 months) grouped by month number => total
            $sixMonthsAgo = now()->subMonths(6)->startOfMonth();
            $salesData = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
                ->where('status', 'completed')
                ->where('created_at', '>=', $sixMonthsAgo)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month'); // [month => total]

            return view('admin.dashboard', compact(
                'totalOrders',
                'pendingOrders',
                'revenue',
                'lowStockItems',
                'recentOrders',
                'salesData'
            ));
        } catch (Exception $ex) {
            // Fail-safe: log and return a minimal dashboard so the page doesn't crash
            Log::error('Dashboard controller error: ' . $ex->getMessage());

            return view('admin.dashboard', [
                'totalOrders' => 0,
                'pendingOrders' => 0,
                'revenue' => 0,
                'lowStockItems' => 0,
                'recentOrders' => collect(),
                'salesData' => collect(),
            ]);
        }
    }
}
