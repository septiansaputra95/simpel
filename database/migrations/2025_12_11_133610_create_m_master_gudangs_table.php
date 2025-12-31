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
        Schema::create('m_master_gudangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_gudang', 150);
            $table->string('nama_gudang', 150);
            $table->string('unitid', 150);
            $table->string('penanggung_jawab', 150);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_master_gudangs');
    }
};
