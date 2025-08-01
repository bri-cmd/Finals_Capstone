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
        Schema::create('gpu_connectors_requireds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('gpu_id')->constrained()->onDelete('cascade');
            $table->string('connector_type')->nullable();
            $table->integer('count')->nullable();
            $table->string('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpu_connectors_requireds');
    }
};
