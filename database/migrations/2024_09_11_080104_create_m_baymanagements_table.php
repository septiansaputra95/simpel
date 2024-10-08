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
        Schema::create('m_baymanagements', function (Blueprint $table) {
            $table->id();
            $table->string('norm', 150)->nullable();
            $table->string('namapasien', 150)->nullable();
            $table->string('dokter', 150)->nullable();
            $table->string('nomorantrian', 150)->nullable();
            $table->string('mulaikonsul', 150)->nullable();
            $table->string('selesaikonsul', 150)->nullable();
            $table->date('tanggal_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_baymanagements');
    }
};
