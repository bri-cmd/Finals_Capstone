<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_builds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('build_name');
            $table->string('case_id');
            $table->string('mobo_id');
            $table->string('cpu_id');
            $table->string('gpu_id');
            $table->string('storage_id');
            $table->string('ram_id');
            $table->string('psu_id');
            $table->string('total_price');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_builds');
    }
};
