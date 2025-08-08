<?php

namespace App\Models\Hardware;

use App\Models\Hardware\PcCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcCaseRadiatorSupport extends Model
{
    /** @use HasFactory<\Database\Factories\PcCaseRadiatorSupportFactory> */
    use HasFactory;

    protected $fillable = [
        'pc_case_id',
        'location',
        'size_mm',
    ];

    public function pcCase() {
        return $this->belongsTo(PcCase::class);
    }
}
