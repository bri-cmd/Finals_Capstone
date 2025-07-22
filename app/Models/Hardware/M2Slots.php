<?php

namespace App\Models\Hardware;

use App\Models\Hardware\Motherboard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M2Slots extends Model
{
    /** @use HasFactory<\Database\Factories\M2SlotsFactory> */
    use HasFactory;

    public function motherboard() {
        return $this->belongsTo(Motherboard::class);
    }
}
