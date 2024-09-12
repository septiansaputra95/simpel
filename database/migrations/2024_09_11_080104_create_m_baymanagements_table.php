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
            $table->string('norm', 150);
            $table->string('namapasien', 150);
            $table->string('dokter', 150);
            $table->string('nomorantrian', 150);
            $table->date('tanggal_data');
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
