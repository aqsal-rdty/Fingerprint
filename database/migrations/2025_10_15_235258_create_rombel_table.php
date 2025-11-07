<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rombel', function (Blueprint $table) {
            $table->string('id_rombel')->primary();
            $table->string('nama_rombel');
            $table->string('id_jurusan');
            $table->timestamps();

            //relasi
            $table->foreign('id_jurusan')
                ->references('id_jurusan')
                ->on('jurusan')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombel');
    }
};
