<?php

namespace App\Models\Hardware;

use App\Models\Hardware\PcCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcCaseFrontUsbPorts extends Model
{
    /** @use HasFactory<\Database\Factories\PcCaseFrontUsbPortsFactory> */
    use HasFactory;

    protected $fillable = [
        'pc_case_id',
        'version',
        'connector',
        'quantity',
    ];

    public function pcCase() {
        return $this->belongsTo(PcCase::class);
    }
}
