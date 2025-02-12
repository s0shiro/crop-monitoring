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
        Schema::table('farmers', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female'])->nullable()->after('name');
            $table->string('rsbsa')->nullable()->after('gender');
            $table->decimal('landsize', 8, 2)->nullable()->after('rsbsa');
            $table->string('barangay')->nullable()->after('location');
            $table->string('municipality')->nullable()->after('barangay');
            $table->dropColumn('location'); // Remove old location field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('farmers', function (Blueprint $table) {
            $table->dropColumn(['gender', 'rsbsa', 'landsize', 'barangay', 'municipality']);
            $table->string('location')->nullable(); // Restore old location field
        });
    }
};
