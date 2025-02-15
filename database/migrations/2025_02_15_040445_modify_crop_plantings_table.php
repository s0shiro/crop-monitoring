<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('crop_plantings', function (Blueprint $table) {
            // Drop the existing location column if it exists
            $table->dropColumn('location');

            // Add new columns for coordinates
            $table->decimal('latitude', 10, 8);  // 10 total digits, 8 decimal places
            $table->decimal('longitude', 11, 8); // 11 total digits, 8 decimal places
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('crop_plantings', function (Blueprint $table) {
            // Reverse the changes
            $table->string('location')->nullable();
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
