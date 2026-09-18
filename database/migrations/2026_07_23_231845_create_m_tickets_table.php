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
        Schema::create('m_tickets', function (Blueprint $table) {
            $table->id();
            // Menggunakan nama kolom yang jelas
            $table->timestamp('gform_timestamp'); 
            $table->string('nama_karyawan')->nullable();
            $table->string('bidang')->nullable();
            $table->text('detail_permohonan')->nullable();
            $table->string('jenis_bantuan')->nullable();
            $table->string('memorandum')->nullable(); // Path/Link file
            $table->boolean('is_done')->default(false); // Sesuai permintaan
            $table->text('keterangan')->nullable();
            $table->boolean('is_report')->default(false); // Sesuai permintaan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_tickets');
    }
};
