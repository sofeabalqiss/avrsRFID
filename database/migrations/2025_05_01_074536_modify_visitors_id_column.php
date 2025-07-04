<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('visitors', function (Blueprint $table) {
            // Just modify the column type without changing the primary key
            $table->unsignedBigInteger('id')->change();  // Change 'id' to BIGINT UNSIGNED
        });
    }

    public function down()
    {
        Schema::table('visitors', function (Blueprint $table) {
            // Revert to INT UNSIGNED if necessary
            $table->unsignedInteger('id')->change();
        });
    }


};
