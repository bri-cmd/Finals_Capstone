<?php

namespace App\Models\Hardware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoboUsbPorts extends Model
{
    /** @use HasFactory<\Database\Factories\UsbPortsFactory> */
    use HasFactory;

    protected $fillable = [
        'motherboard_id',
        'version',
        'location',
        'type',
        'quantity',
    ];


    public function motherboard() {
        return $this->belongsTo(Motherboard::class);
    }
}
