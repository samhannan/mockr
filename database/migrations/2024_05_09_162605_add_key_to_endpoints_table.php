<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('endpoints', function (Blueprint $table) {
            $table->string('key')->unique()->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('endpoints', function (Blueprint $table) {
            //
        });
    }
};
