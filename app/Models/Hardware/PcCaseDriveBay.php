<?php

namespace App\Models\Hardware;

use App\Models\Hardware\PcCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcCaseDriveBay extends Model
{
    /** @use HasFactory<\Database\Factories\PcCaseDriveBaysFactory> */
    use HasFactory;

    protected $fillable = [
        'pc_case_id',
        'size_inch',
        'drive_type',
        'quantity',
    ];

    public function pcCase() {
        return $this->belongsTo(PcCase::class);
    }
}
