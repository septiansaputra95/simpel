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
        Schema::create('trainingwhatsapps', function (Blueprint $table) {
            $table->id();
            $table->string('percakapan', 150)->nullable();
            $table->string('tipe', 150)->nullable();
            $table->string('pesan', 150)->nullable();
            $table->string('nomorpesan', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainingwhatsapps');
    }
};
