<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visits', function (Blueprint $table) {
            // Modify 'visitor_id' column to BIGINT UNSIGNED
            $table->unsignedBigInteger('visitor_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visits', function (Blueprint $table) {
            // Revert 'visitor_id' back to INT UNSIGNED (if needed)
            $table->unsignedInteger('visitor_id')->change();
        });
    }
};
