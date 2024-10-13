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
        Schema::create('m_pesertas', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 150)->nullable();
            $table->string('nama', 150)->nullable();
            $table->string('noKartu', 150)->nullable();
            $table->string('noMr', 150)->nullable();
            $table->string('noTelepon', 150)->nullable();
            $table->string('pisa', 150)->nullable();
            $table->string('kdprovider', 150)->nullable();
            $table->string('nmprovider', 150)->nullable();
            $table->string('kodekelas', 150)->nullable();
            $table->string('kelas', 150)->nullable();
            $table->string('statuspesertakode', 150)->nullable();
            $table->string('statuspesertaketerangan', 150)->nullable();
            $table->string('jenispesertakode', 150)->nullable();
            $table->string('jenispesertaketerangan', 150)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_pesertas');
    }
};
