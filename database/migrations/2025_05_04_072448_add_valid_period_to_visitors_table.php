<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->timestamp('valid_from')->nullable()->after('rfid_id');
            $table->timestamp('valid_until')->nullable()->after('valid_from');
        });
    }

    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropColumn(['valid_from', 'valid_until']);
        });
    }
};

