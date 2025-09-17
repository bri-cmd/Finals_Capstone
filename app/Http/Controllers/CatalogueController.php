<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        // 1) Map tables to category names
        $maps = [
            'cpus'         => 'cpu',
            'gpus'         => 'gpu',
            'motherboards' => 'motherboard',
            'rams'         => 'ram',
            'storages'     => 'storage',
            'psus'         => 'psu',
            'cases'        => 'case',
            'coolers'      => 'cooler',
        ];

        $all = collect();

        foreach ($maps as $table => $category) {
            if (!Schema::hasTable($table)) {
                continue; // skip if table not migrated yet
            }

            // Grab all rows (all fields)
            $rows = DB::table($table)->get();

            $normalized = $rows->map(function ($row) use ($category, $table) {
                $rowArr = (array) $row;

                // Common fields
                $common = [
                    'id'             => (int) ($rowArr['id'] ?? 0),
                    'component_type' => strtolower($category),
                    'table'          => $table,
                    'name'           => trim(($rowArr['brand'] ?? '') . ' ' . ($rowArr['model'] ?? '')),
                    'brand'          => (string) ($rowArr['brand'] ?? ''),
                    'category'       => $category,
                    'price'          => (float) ($rowArr['price'] ?? 0),
                    'stock'          => (int) ($rowArr['stock'] ?? 0),
                    'image'          => $rowArr['image'] ?? 'images/placeholder.png',
                    'created_at'     => $rowArr['created_at'] ?? now(),
                ];

                // Specs = all fields except the common ones
                $exclude = ['id','brand','model','price','stock','image','created_at','updated_at'];
                $specs = collect($rowArr)->except($exclude)->toArray();

                $common['specs'] = $specs;

                return $common;
            });

            $all = $all->merge($normalized);
        }

        // 2) Filters
        $filtered = $all;

        if ($request->filled('search')) {
            $q = mb_strtolower($request->input('search'));
            $filtered = $filtered->filter(function ($item) use ($q) {
                $hay = mb_strtolower($item['name'] . ' ' . $item['brand'] . ' ' . $item['category']);
                return strpos($hay, $q) !== false;
            });
        }

        if ($request->filled('category')) {
            $filtered = $filtered->filter(fn ($i) => $i['category'] === $request->category);
        }

        if ($request->filled('brand')) {
            $filtered = $filtered->filter(fn ($i) => $i['brand'] === $request->brand);
        }

        if ($request->filled('min_price')) {
            $min = (float) $request->min_price;
            $filtered = $filtered->filter(fn ($i) => $i['price'] >= $min);
        }

        if ($request->filled('max_price')) {
            $max = (float) $request->max_price;
            $filtered = $filtered->filter(fn ($i) => $i['price'] <= $max);
        }

        // 3) Sorting
        switch ($request->input('sort')) {
            case 'newest':
                $filtered = $filtered->sortByDesc('created_at');
                break;
            case 'price_asc':
                $filtered = $filtered->sortBy('price');
                break;
            case 'price_desc':
                $filtered = $filtered->sortByDesc('price');
                break;
            case 'name_asc':
                $filtered = $filtered->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);
                break;
            case 'name_desc':
                $filtered = $filtered->sortByDesc('name', SORT_NATURAL | SORT_FLAG_CASE);
                break;
            default:
                $filtered = $filtered->sortByDesc('created_at');
        }

        // 4) Sidebar filters
        $categories = $all->pluck('category')->unique()->values();
        $brands     = $all->pluck('brand')->filter()->unique()->sort()->values();

        // 5) Pagination
        $perPage = 12;
        $page    = (int) ($request->get('page', 1));
        $total   = $filtered->count();
        $items   = $filtered->slice(($page - 1) * $perPage, $perPage)->values();

        $products = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('catalogue', compact('products', 'categories', 'brands'));
    }
}
