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
        if (Schema::hasColumn('crops', 'variety_id')) {
            Schema::table('crops', function (Blueprint $table) {
                $table->dropColumn('variety_id');
            });
        }
    }

    public function down()
    {
        if (!Schema::hasColumn('crops', 'variety_id')) {
            Schema::table('crops', function (Blueprint $table) {
                $table->foreignId('variety_id')->nullable()->constrained('varieties')->onDelete('set null');
            });
        }
    }
};
