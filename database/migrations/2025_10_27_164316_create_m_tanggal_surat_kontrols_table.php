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
        Schema::create('m_tanggal_surat_kontrols', function (Blueprint $table) {
            $table->id();
            $table->string('nosuratkontrol', 150)->nullable();
            $table->string('jenispelayanan', 150)->nullable();
            $table->string('jeniskontrol', 150)->nullable();
            $table->string('namajeniskontrol', 150)->nullable();
            $table->date('tglrencanankontrol')->nullable();
            $table->date('tglterbitkontrol')->nullable();
            $table->string('nosepasalkontrol', 150)->nullable();
            $table->string('poliasal', 150)->nullable();
            $table->string('namapoliasal', 150)->nullable();
            $table->string('politujuan', 150)->nullable();
            $table->string('namapolitujuan', 150)->nullable();
            $table->date('tglsep')->nullable();
            $table->string('kodedokter', 150)->nullable();
            $table->string('namadokter', 150)->nullable();
            $table->string('nokartu', 150)->nullable();
            $table->string('nama', 150)->nullable();
            $table->string('terbitsep', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_tanggal_surat_kontrols');
    }
};
