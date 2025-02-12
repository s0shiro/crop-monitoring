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
        Schema::table('varieties', function (Blueprint $table) {
            $table->foreignId('crop_id')->constrained('crops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('varieties', function (Blueprint $table) {
            $table->dropForeign(['crop_id']);
            $table->dropColumn('crop_id');
        });
    }
};
