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
        Schema::table('visitors', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();  // Change 'id' to BIGINT (unsigned)
        });
    }

    public function down()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->integer('id')->change();  // Revert to INT if necessary
        });
    }

};
