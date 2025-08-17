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
        'pcie_slots',
        'm2_slots',
        'sata_ports',
        'usb_ports',
        'wifi_onboard',
        'price',
        'stock',
        'image',
        'model_3d',
    ];

    // FETCHING IMAGE FROM DRIVE
    protected $casts = [
        'image' => 'array',
    ];

    // DEFINE RELATIONSHIP
    public function buildCategory() {
        return $this->belongsTo(BuildCategory::class);
    }
}
