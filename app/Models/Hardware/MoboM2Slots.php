<?php

namespace App\Models\Hardware;

use App\Models\Hardware\Motherboard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoboM2Slots extends Model
{
    /** @use HasFactory<\Database\Factories\M2SlotsFactory> */
    use HasFactory;

    protected $fillable = [
        'motherboard_id',
        'length',
        'version',
        'lane_type',
        'supports_sata',
        'quantity',
    ];

    public function motherboard() {
        return $this->belongsTo(Motherboard::class);
    }
}
