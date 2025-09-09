<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedBuild extends Model
{
    /** @use HasFactory<\Database\Factories\OrderedBuildFactory> */
    use HasFactory;
    protected $fillable = [
        'user_build_id',
        'status',
        'user_id',
        'payment_status',
        'payment_method',
        'pickup_status',
        'pickup_date',
    ];

    public function userBuild() {
        return $this->belongsTo(UserBuild::class);
    }
}
