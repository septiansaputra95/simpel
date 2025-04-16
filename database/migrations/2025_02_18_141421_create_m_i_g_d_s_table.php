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
        Schema::create('m_i_g_d_s', function (Blueprint $table) {
            $table->id();
            $table->string('timestamp', 150)->nullable();
            $table->string('namapasien', 150)->nullable();
            $table->string('nrm', 150)->nullable();
            $table->string('nomorhp', 150)->nullable();
            $table->boolean('pengirimanwa')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_i_g_d_s');
    }
};
