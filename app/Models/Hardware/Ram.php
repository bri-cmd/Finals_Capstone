<?php

namespace App\Models\Hardware;

use App\Models\BuildCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ram extends Model
{
    /** @use HasFactory<\Database\Factories\RamFactory> */
    use HasFactory;

    protected $fillable = [
        'build_category_id',
        'brand',
        'model',
        'ram_type',
        'speed_mhz',
        'size_per_module_gb',
        'total_capacity_gb',
        'module_count',
        'is_ecc',
        'is_rgb',
        'price',
        'stock',
        'image',
        'model_3d',
    ];

    // DEFINE RELATIONSHIP
    public function buildCategory() {
        return $this->belongsTo(BuildCategory::class);
    }
}
