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
        Schema::table('crops', function (Blueprint $table) {
            $table->foreignId('variety_id')->nullable()->constrained('varieties')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('crops', function (Blueprint $table) {
            $table->dropForeign(['variety_id']);
            $table->dropColumn('variety_id');
        });
    }
};
