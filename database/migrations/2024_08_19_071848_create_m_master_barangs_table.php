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
          
            $table->string('kode_kelompok', 150)->nullable();
            $table->string('kode_kategori', 150)->nullable();
            $table->string('kode_jenis_barang', 150)->nullable();
            $table->string('kode_golongan_barang', 150)->nullable();
            $table->string('kode_pabrik', 150)->nullable();

            // Informasi obat
            $table->boolean('is_generik')->default(false);
            $table->boolean('is_formularium')->default(false);
            $table->string('dosis', 100)->nullable(); // by MG
            $table->string('kode_satuan_besar', 150)->nullable();
            $table->string('kode_satuan_kecil', 150)->nullable();

            // Detail harga dan stok
            $table->integer('isi')->nullable();
            $table->decimal('harga_hna', 15, 2)->nullable();
            $table->decimal('ppn', 5, 2)->nullable();
            $table->integer('minimal_stok')->nullable();

            // Status dan deskripsi
            $table->boolean('is_active')->default(true);
            $table->text('keterangan')->nullable();

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
