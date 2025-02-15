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
        Schema::create('rice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_planting_id')->constrained()->onDelete('cascade');
            $table->enum('water_supply', ['irrigated', 'rainfed']);
            $table->enum('land_type', ['lowland', 'upland'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rice_details');
    }
};
