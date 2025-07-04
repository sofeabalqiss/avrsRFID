<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rfids', function (Blueprint $table) {
            $table->id();  // 'id' column as primary key (auto-increment)
            $table->string('rfid_string', 255);  // Stores the actual RFID string
            $table->enum('status', ['active', 'inactive'])->default('inactive');  // Status of the RFID
            $table->timestamps();  // Created and updated timestamp columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('rfids');
    }

};
