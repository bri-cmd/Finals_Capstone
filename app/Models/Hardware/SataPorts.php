<?php

namespace App\Models\Hardware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SataPorts extends Model
{
    /** @use HasFactory<\Database\Factories\SataPortsFactory> */
    use HasFactory;

    public function motherboard() {
        return $this->belongsTo(Motherboard::class);
    }
}
