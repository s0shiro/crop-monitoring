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
            $table->decimal('harvested_area', 10, 2)->default(0)->after('area_planted');
            $table->decimal('remaining_area', 10, 2)->after('harvested_area');
        });

        // Set initial remaining_area for existing records
        DB::statement('UPDATE crop_plantings SET remaining_area = area_planted');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('crop_plantings', function (Blueprint $table) {
            $table->dropColumn(['harvested_area', 'remaining_area']);
        });
    }
};
