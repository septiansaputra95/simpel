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
        Schema::create('m_permintaan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kode_permintaan')->constrained('m_permintaan_headers')->cascadeOnDelete();
            $table->foreignId('kode_barang')->constrained('m_master_barangs')->cascadeOnDelete();
            $table->decimal('harga',15,2);
            $table->integer('jumlah');
            $table->decimal('subtotal',15,2);
            $table->decimal('diskon',15,2)->default(0);
            $table->decimal('ppn',15,2)->default(0);
            $table->decimal('total',15,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_permintaan_details');
    }
};
