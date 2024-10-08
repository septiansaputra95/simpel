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
        Schema::create('m_vclaim_s_e_p_s', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 150)->nullable();
            $table->string('nomor_sep', 150)->nullable();
            $table->string('tanggal_sep', 150)->nullable();
            $table->string('rirj', 150)->nullable();
            $table->string('nomor_kartu', 150)->nullable();
            $table->string('nama_peserta', 150)->nullable();
            $table->string('diagnosa', 150)->nullable();
            $table->string('poli', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_vclaim_s_e_p_s');
    }
};
