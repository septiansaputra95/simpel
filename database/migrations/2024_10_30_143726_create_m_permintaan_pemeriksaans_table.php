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
        Schema::create('m_permintaan_pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->string('timestamp', 150)->index()->unique();
            $table->string('namapemohon', 150)->nullable();
            $table->string('hubunganpasien', 150)->nullable();
            $table->string('namapasien', 150)->nullable();
            $table->string('norekammedis', 150)->nullable();
            $table->string('datadiminta', 150)->nullable();
            $table->string('tanggalpemeriksaan', 150)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('nomorwa', 150)->nullable();
            $table->string('namadokter', 150)->nullable();
            $table->boolean('notifikasiwa')->default(0); 
            $table->boolean('statuskirim')->default(0); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_permintaan_pemeriksaans');
    }
};
