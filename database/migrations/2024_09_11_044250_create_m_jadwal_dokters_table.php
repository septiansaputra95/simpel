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
        Schema::create('m_jadwal_dokters', function (Blueprint $table) {
            $table->id();
            $table->string('kodesubspesialis', 150);
            $table->string('hari', 150);
            $table->integer('kapasitaspasien');
            $table->string('libur', 150);
            $table->string('namahari', 150);
            $table->string('jadwal', 150);
            $table->string('namasubspesialis', 150);
            $table->string('namadokter', 150);
            $table->string('kodepoli', 150);
            $table->string('namapoli', 150);
            $table->string('kodedokter', 150);
            $table->date('tanggal_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_jadwal_dokters');
    }
};
