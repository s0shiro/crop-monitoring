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
            $table->string('municipality')->nullable()->after('longitude');
            $table->string('barangay')->nullable()->after('municipality');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('crop_plantings', function (Blueprint $table) {
            $table->dropColumn(['municipality', 'barangay']);
        });
    }
};
