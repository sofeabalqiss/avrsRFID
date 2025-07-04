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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();  // Primary key for 'visits' table
            $table->foreignId('visitor_id')->constrained('visitors')->onDelete('cascade');  // Create foreign key for 'visitor_id'
            $table->timestamp('check_in')->nullable();  // Check-in timestamp
            $table->timestamp('check_out')->nullable();  // Check-out timestamp
            $table->timestamps();  // Created and updated timestamp columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('visits');
    }

};
