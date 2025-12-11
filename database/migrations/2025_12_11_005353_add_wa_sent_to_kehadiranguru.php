<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kehadiranguru', function (Blueprint $table) {
            $table->boolean('wa_sent')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('kehadiranguru', function (Blueprint $table) {
            $table->dropColumn('wa_sent');
        });
    }
};
