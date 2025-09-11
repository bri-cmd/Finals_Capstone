<?php

namespace App\Models\Hardware;

use App\Models\Hardware\PcCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PcCaseRadiatorSupport extends Model
{
    /** @use HasFactory<\Database\Factories\PcCaseRadiatorSupportFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'pc_case_id',
        'location',
        'size_mm',
    ];

    public function pcCase() {
        return $this->belongsTo(PcCase::class);
    }
}
