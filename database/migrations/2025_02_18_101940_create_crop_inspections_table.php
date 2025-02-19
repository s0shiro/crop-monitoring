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
        Schema::create('crop_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_planting_id')->constrained('crop_plantings')->onDelete('cascade');
            $table->foreignId('technician_id')->constrained('users')->onDelete('cascade');
            $table->date('inspection_date');
            $table->text('remarks')->nullable();
            $table->decimal('damaged_area', 8, 2)->default(0); // Area damaged in hectares
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_inspections');
    }
};
