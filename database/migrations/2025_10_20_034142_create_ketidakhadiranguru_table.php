<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ketidakhadiranguru', function (Blueprint $table) {
            $table->id('id_ketidakhadiran');
            $table->integer('nip')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('ket', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ketidakhadiranguru');
    }
};