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
        Schema::create('hvc_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_planting_id')->constrained()->onDelete('cascade');
            $table->enum('classification', [
                'lowland vegetable',
                'upland vegetable',
                'legumes',
                'spice',
                'rootcrop',
                'fruit'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hvc_details');
    }
};
