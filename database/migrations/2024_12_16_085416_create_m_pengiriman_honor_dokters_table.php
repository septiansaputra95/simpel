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
        Schema::create('m_pengiriman_honor_dokters', function (Blueprint $table) {
            $table->id();
            $table->string('kodedokter', 150);
            $table->date('tanggalawal');
            $table->date('tanggalakhir');
            $table->string('file', 150);
            $table->boolean('flagkirim');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_pengiriman_honor_dokters');
    }
};
