<?php

namespace App\Models\Hardware;

use App\Models\Hardware\Motherboard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcieSlots extends Model
{
    /** @use HasFactory<\Database\Factories\PcieSlotsFactory> */
    use HasFactory;

    // DEFINE RELATIONSHIP
    public function motherboard() {
        return $this->belongsTo(Motherboard::class);
    }
}
