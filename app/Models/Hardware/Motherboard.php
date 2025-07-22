<?php

namespace App\Models\Hardware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motherboard extends Model
{
    /** @use HasFactory<\Database\Factories\MotherboardFactory> */
    use HasFactory;

    // DEFINE RELATIONSHIP
    public function pcieSlots() {
        return $this->hasMany(PcieSlots::class);
    }

    public function m2Slots() {
        return $this->hasMany(M2Slots::class);
    }

    public function sataPorts() {
        return $this->hasMany(SataPorts::class);
    }

    public function usbPorts() {
        return $this->hasMany(UsbPorts::class);
    }
}
