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
        Schema::create('usb_ports',function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('motherboard_id')->constrained()->onDelete('cascade');
            $table->string('version');
            $table->string('location');
            $table->string('type')->default('Type-A');
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usb_ports');
    }
};
