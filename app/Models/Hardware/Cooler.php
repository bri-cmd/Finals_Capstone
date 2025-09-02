<?php

namespace App\Models\Hardware;

use App\Models\BuildCategory;
use App\Models\UserBuild;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cooler extends Model
{
    /** @use HasFactory<\Database\Factories\CoolerFactory> */
    use HasFactory;

    protected $fillable = [
        'build_category_id',
        'brand',
        'model',
        'cooler_type',
        'socket_compatibility',
        'max_tdp',
        'radiator_size_mm',
        'fan_count',
        'height_mm',
        'price',
        'stock',
        'image',
        'model_3d',
    ];

    // FETCHING IMAGE FROM DRIVE
    protected $casts = [
        'image' => 'array',
        'socket_compatibility' => 'array',

    ];

    // DEFINE RELATIONSHIP
    public function buildCategory() {
        return $this->belongsTo(BuildCategory::class);
    }

    public function userBuild() {
        return $this->hasMany(UserBuild::class);
    }
}
