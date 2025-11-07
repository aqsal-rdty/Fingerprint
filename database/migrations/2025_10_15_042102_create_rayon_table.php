<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rayon', function (Blueprint $table) {
            $table->string('id_rayon')->primary();
            $table->string('nama_rayon');
            $table->string('pembimbing_id')->nullable();
            $table->string('nomor_ruangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rayon');
    }
};
