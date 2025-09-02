<?php

namespace App\Models\Hardware;

use App\Models\BuildCategory;
use App\Models\Hardware\PcCaseDriveBay;
use App\Models\Hardware\PcCaseFrontUsbPorts;
use App\Models\Hardware\PcCaseRadiatorSupport;
use App\Models\UserBuild;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcCase extends Model
{
    /** @use HasFactory<\Database\Factories\PcCaseFactory> */
    use HasFactory;

    protected $fillable = [
        'build_category_id',
        'brand',
        'model',
        'form_factor_support',
        'max_gpu_length_mm',
        'max_cooler_height_mm',
        'fan_mounts',
        'price',
        'stock',
        'image',
        'model_3d',
    ];  

    // FETCHING IMAGE FROM DRIVE
    protected $casts = [
        'image' => 'array',
    ];

    public function buildCategory() {
        return $this->belongsTo(BuildCategory::class);
    }
    
    public function driveBays() {
        return $this->hasMany(PcCaseDriveBay::class);
    }

    public function usbPorts() {
        return $this->hasMany(PcCaseFrontUsbPorts::class);
    }

    public function radiatorSupports() {
        return $this->hasMany(PcCaseRadiatorSupport::class);
    }

    public function userBuild() {
        return $this->hasMany(UserBuild::class);
    }
}
