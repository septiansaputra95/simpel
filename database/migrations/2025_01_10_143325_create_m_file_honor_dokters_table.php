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
        Schema::create('m_file_honor_dokters', function (Blueprint $table) {
            $table->id();
            $table->string('idpengiriman', 150);
            $table->string('kodedokter', 150);
            $table->string('file', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_file_honor_dokters');
    }
};
