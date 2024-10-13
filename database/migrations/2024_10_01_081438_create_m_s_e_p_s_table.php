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
        Schema::create('m_s_e_p_s', function (Blueprint $table) {
            $table->id();
            $table->string('nosep', 150)->nullable();
            $table->string('tglsep', 150)->nullable();
            $table->string('kelasrawat', 150)->nullable();
            $table->string('diagnosa', 150)->nullable();
            $table->string('norujukan', 150)->nullable();
            $table->string('poli', 150)->nullable();
            $table->string('nokartu', 150)->nullable();
            $table->string('nama', 150)->nullable();
            $table->string('nomr', 150)->nullable();
            $table->string('kddpjp', 150)->nullable();
            $table->string('nmdpjp', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_s_e_p_s');
    }
};
