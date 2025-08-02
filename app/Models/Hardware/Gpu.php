<?php

namespace App\Models\Hardware;

use App\Models\BuildCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gpu extends Model
{
    /** @use HasFactory<\Database\Factories\GpuFactory> */
    use HasFactory;

    public function buildCategory() {
        return $this->belongsTo(BuildCategory::class);
    }
}
