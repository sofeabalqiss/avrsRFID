<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToRfidsTable extends Migration
{
    public function up()
    {
        Schema::table('rfids', function (Blueprint $table) {
            // Check if 'status' column exists; if unsure, just add type without 'after'
            if (Schema::hasColumn('rfids', 'status')) {
                $table->enum('type', ['reusable', 'permanent'])
                    ->default('reusable')
                    ->after('status');
            } else {
                $table->enum('type', ['reusable', 'permanent'])
                    ->default('reusable');
            }
        });
    }

    public function down()
    {
        Schema::table('rfids', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
