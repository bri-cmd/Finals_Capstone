<?php

namespace App\Models\Hardware;

use App\Models\BuildCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motherboard extends Model
{
    /** @use HasFactory<\Database\Factories\MotherboardFactory> */
    use HasFactory;

    protected $fillable = [
        'build_category_id',
        'brand',
        'model',
        'socket_type',
        'chipset',
        'form_factor',
        'ram_type',
        'max_ram',
        'ram_slots',
        'max_ram_speed',
        'wifi_onboard',
        'price',
        'stock',
        'image',
        'model_3d',
    ];

    // DEFINE RELATIONSHIP
    public function buildCategory() {
        return $this->belongsTo(BuildCategory::class);
    }

    public function pcieSlots() {
        return $this->hasMany(MoboPcieSlot::class);
    }

    public function m2Slots() {
        return $this->hasMany(MoboM2Slots::class);
    }

    public function sataPorts() {
        return $this->hasMany(MoboSataPorts::class);
    }

    public function usbPorts() {
        return $this->hasMany(MoboUsbPorts::class);
    }
}
