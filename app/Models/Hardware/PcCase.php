<?php

namespace App\Models\Hardware;

use App\Models\BuildCategory;
use App\Models\Hardware\PcCaseDriveBay;
use App\Models\Hardware\PcCaseFanMount;
use App\Models\Hardware\PcCaseFormFactorSupport;
use App\Models\Hardware\PcCaseFrontUsbPorts;
use App\Models\Hardware\PcCaseRadiatorSupport;
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
        'max_gpu_length_mm',
        'max_cooler_height_mm',
        'price',
        'stock',
        'image',
        'model_3d',
    ];  

    public function buildCategory() {
        return $this->belongsTo(BuildCategory::class);
    }

    public function formFactors() {
        return $this->hasMany(PcCaseFormFactorSupport::class);
    }
    
    public function driveBays() {
        return $this->hasMany(PcCaseDriveBay::class);
    }

    public function fanMounts() {
        return $this->hasMany(PcCaseFanMount::class);
    }

    public function usbPorts() {
        return $this->hasMany(PcCaseFrontUsbPorts::class);
    }

    public function radiatorSupports() {
        return $this->hasMany(PcCaseRadiatorSupport::class);
    }
}
