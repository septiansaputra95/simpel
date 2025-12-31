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
        Schema::create('m_gudang_stoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gudang_id')
                    ->constrained('m_master_gudangs')
                    ->onDelete('cascade');
            $table->foreignId('barang_id')
                    ->constrained('m_master_barangs')
                    ->onDelete('cascade');
            $table->string('kode_gudang', 150);
            $table->string('kode_barang', 150);
            $table->string('batch_barang', 150);
            $table->string('kode_satuan', 150);
            $table->date('expired_date')->nullable();
            $table->decimal('harga_barang', 15, 2)->default(0);
            $table->integer('stok_barang')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Kombinasi unik antar kolom
            $table->unique(['gudang_id', 'barang_id', 'batch_barang'], 'unik_stok_per_gudang_barang_batch');
            // $table->foreign('kode_gudang')->references('id')->on('m_master_gudangs')->onDelete('cascade');
            // $table->foreign('kode_barang')->references('id')->on('m_master_barangs')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_gudang_stoks');
    }
};
