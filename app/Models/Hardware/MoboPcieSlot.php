<?php

namespace App\Models\Hardware;

use App\Models\Hardware\Motherboard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoboPcieSlot extends Model
{
    /** @use HasFactory<\Database\Factories\MoboPcieSlotFactory> */
    use HasFactory;

    protected $fillable = [
        'motherboard_id',
        'version',
        'lane_type',
        'add_notes',
        'quantity',
    ];

    // DEFINE RELATIONSHIP
    public function motherboard() {
        return $this->belongsTo(Motherboard::class);
    }
}
