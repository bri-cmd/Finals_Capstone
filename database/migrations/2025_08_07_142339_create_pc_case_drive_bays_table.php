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
        Schema::create('pc_case_drive_bays', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('pc_case_id')->constrained()->onDelete('cascade');
            $table->decimal('size_inch',3,2)->nullable();
            $table->string('drive_type');
            $table->integer('quantity');
            $table->string('is_combo')->nullable();
            $table->string('requires_layout')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pc_case_drive_bays');
    }
};
