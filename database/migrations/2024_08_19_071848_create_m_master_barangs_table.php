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
        Schema::create('m_master_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->index()->unique();
            $table->string('nama_barang', 150);
            $table->string('harga_barang', 150);
            $table->string('kode_satuan', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_master_barangs');
    }
};
