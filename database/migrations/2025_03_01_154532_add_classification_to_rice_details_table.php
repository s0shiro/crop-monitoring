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
        Schema::table('rice_details', function (Blueprint $table) {
            $table->string('classification')->nullable()->after('crop_planting_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rice_details', function (Blueprint $table) {
            $table->dropColumn('classification');
        });
    }
};
