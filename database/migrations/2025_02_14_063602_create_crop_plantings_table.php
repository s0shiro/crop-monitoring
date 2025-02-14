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
        Schema::create('crop_plantings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained('farmers')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('crop_id')->constrained('crops')->onDelete('cascade');
            $table->foreignId('variety_id')->constrained('varieties')->onDelete('cascade');
            $table->date('planting_date');
            $table->date('expected_harvest_date')->nullable();
            $table->decimal('area_planted', 8, 2);
            $table->integer('quantity');
            $table->decimal('expenses', 10, 2)->nullable();
            $table->foreignId('technician_id')->constrained('users')->onDelete('cascade'); // Assigned technician
            $table->text('remarks')->nullable();
            $table->string('location'); // Field location
            $table->enum('status', ['standing', 'harvest', 'harvested'])->default('standing'); // Status field
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crop_plantings');
    }
};
