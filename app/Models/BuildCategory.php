<?php

namespace App\Models;

use App\Models\Hardware\Gpu;
use App\Models\Hardware\Motherboard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildCategory extends Model
{
    /** @use HasFactory<\Database\Factories\BuildCategoryFactory> */
    use HasFactory;

    public function motherboard() {
        return $this->hasMany(Motherboard::class);
        return $this->hasMany(Gpu::class);
    }
}
