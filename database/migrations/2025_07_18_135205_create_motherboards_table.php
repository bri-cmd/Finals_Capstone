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
        Schema::create('motherboards', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('category_id')->constrained()->onDelete('cascade');
            $table->string('brand');
            $table->string('model');
            $table->string('socket_type');
            $table->string('chipset');
            $table->string('form_factor');
            $table->string('ram_type');
            $table->integer('max_ram');
            $table->integer('ram_slots');
            $table->integer('max_ram_speed');
            // $table->integer('pcie_slots');
            // $table->integer('m2_slots');
            // $table->integer('sata_ports');
            // $table->integer('usb_ports');
            $table->string('wifi_onboard');
            $table->decimal('price',10,2);
            $table->integer('stock');
            $table->string('image');
            $table->string('model_3d')->nullable();
        });

        // EXPANDABLE SPECS 
        Schema::create('pcie_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motherboard_id')->constrained()->onDelete('cascade');
            $table->decimal('version',2,1);
            $table->string('lane_type');
            $table->integer('quantity')->default(1);
        });

        Schema::create('m2_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motherboard_id')->constrained()->onDelete('cascade');
            $table->integer('length');
            $table->decimal('version',2,1);
            $table->string('lane_type');
            $table->integer('quantity')->default(1);
        });

        Schema::create('sata_ports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motherboard_id')->constrained()->onDelete('cascade');
            $table->decimal('version',3,1);
            $table->integer('quantity')->default(1);
        });

        Schema::create('usb_ports',function (Blueprint $table) {
            $table->id();
            $table->foreignId('motherboard_id')->constrained()->onDelete('cascade');
            $table->string('version');
            $table->string('location');
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motherboards');
    }
};
