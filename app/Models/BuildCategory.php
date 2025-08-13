<?php

namespace App\Models;

use App\Models\Hardware\Cpu;
use App\Models\Hardware\Gpu;
use App\Models\Hardware\Motherboard;
use App\Models\Hardware\PcCase;
use App\Models\Hardware\Psu;
use App\Models\Hardware\Ram;
use App\Models\Hardware\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildCategory extends Model
{
    /** @use HasFactory<\Database\Factories\BuildCategoryFactory> */
    use HasFactory;

    public function motherboard() {
        return $this->hasMany(Motherboard::class);
        return $this->hasMany(Gpu::class);
        return $this->hasMany(PcCase::class);
        return $this->hasMany(Psu::class);
        return $this->hasMany(Ram::class);
        return $this->hasMany(Storage::class);
        return $this->hasMany(Cpu::class);
    }
}
