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
        Schema::create('m_master_dokters', function (Blueprint $table) {
            $table->id();
            $table->string('kodedokter', 150);
            $table->string('namadokter', 150);
            $table->string('emaildokter', 150)->nullable();
            $table->string('nomorhp', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_master_dokters');
    }
};
