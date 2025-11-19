<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kehadiranguru', function (Blueprint $table) {
            $table->id('id_kehadiran');
            $table->integer('nip')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('waktu')->nullable();
            $table->time('pulang')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kehadiranguru');
    }
};