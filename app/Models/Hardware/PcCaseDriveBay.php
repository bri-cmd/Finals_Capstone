<?php

namespace App\Models\Hardware;

use App\Models\Hardware\PcCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PcCaseDriveBay extends Model
{
    /** @use HasFactory<\Database\Factories\PcCaseDriveBaysFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'pc_case_id',
        '3_5_bays',
        '2_5_bays',
    ];

    public function pcCase() {
        return $this->belongsTo(PcCase::class);
    }
}
