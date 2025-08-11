<?php

namespace App\Models\Hardware;

use App\Models\BuildCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ram extends Model
{
    /** @use HasFactory<\Database\Factories\RamFactory> */
    use HasFactory;

    // DEFINE RELATIONSHIP
    public function buildCategory() {
        return $this->belongsTo(BuildCategory::class);
    }
}
