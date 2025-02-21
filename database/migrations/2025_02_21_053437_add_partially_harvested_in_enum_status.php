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
        DB::statement("ALTER TABLE crop_plantings MODIFY COLUMN status ENUM('standing', 'harvest', 'partially harvested', 'harvested')");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement("ALTER TABLE crop_plantings MODIFY COLUMN status ENUM('standing', 'harvest', 'harvested')");
    }
};
