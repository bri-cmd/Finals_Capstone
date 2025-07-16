<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBuild extends Model
{
    /** @use HasFactory<\Database\Factories\UserBuildFactory> */
    use HasFactory;

    protected $fillable = [
        'build_name',
        'case_id',
        'mobo_id',
        'cpu_id',
        'gpu_id',
        'storage_id',
        'ram_id',
        'psu_id',
        'total_price',
        'status',
    ];
}
