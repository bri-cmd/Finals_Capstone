<?php

namespace App\Models\Hardware;

use App\Models\Hardware\PcCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcCaseFanMount extends Model
{
    /** @use HasFactory<\Database\Factories\PcCaseFanMountFactory> */
    use HasFactory;

    protected $fillable = [
        'pc_case_id',
        'location',
        'size_mm',
        'quantity',
    ];

    public function pcCase() {
        return $this->belongsTo(PcCase::class);
    }
}
