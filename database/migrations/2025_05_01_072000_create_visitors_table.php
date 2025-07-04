<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->bigIncrements('id');  // Primary key: 'id' column (BIGINT auto-increment)
            $table->string('ic_number', 255);  // IC Number (VARCHAR)
            $table->string('name_printed', 255);  // Printed Name (VARCHAR)
            $table->text('address_1');  // Address (TEXT)
            $table->string('visitor_type', 255);  // Visitor type (VARCHAR)
            $table->string('vehicle_plate', 20);  // Vehicle plate (VARCHAR)
            $table->string('house_number', 255);  // House number (VARCHAR)
            $table->unsignedBigInteger('rfid_id');  // Foreign key referencing 'rfids.id'
            $table->foreign('rfid_id')->references('id')->on('rfids')->onDelete('cascade'); // Ensure foreign key relationship
            $table->timestamps();  // Created and updated timestamp columns
        });
    }


    public function down()
    {
        Schema::dropIfExists('visitors');
    }
};
