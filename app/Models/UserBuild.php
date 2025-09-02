<?php

namespace App\Models;

use App\Models\Hardware\Cooler;
use App\Models\Hardware\Cpu;
use App\Models\Hardware\Gpu;
use App\Models\Hardware\Motherboard;
use App\Models\Hardware\PcCase;
use App\Models\Hardware\Psu;
use App\Models\Hardware\Ram;
use App\Models\Hardware\Storage;
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

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function motherboard() {
        return $this->belongsTo(Motherboard::class);
    }

    public function cpus() {
        return $this->belongsTo(Cpu::class);
    }

    public function case() {
        return $this->belongsTo(PcCase::class);
    }

    public function gpu() {
        return $this->belongsTo(Gpu::class);
    }

    public function psu() {
        return $this->belongsTo(Psu::class);

    }

    public function storage() {
        return $this->belongsTo(Storage::class);
    }

    public function ram() {
        return $this->belongsTo(Ram::class);
    }
    
    public function cooler() {
        return $this->belongsTo(Cooler::class);
    }
}
