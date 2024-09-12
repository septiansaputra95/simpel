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
            $table->string('nik', 150);
            $table->string('nama', 150);
            $table->string('noKartu', 150);
            $table->string('pisa', 150);
            $table->string('kdprovider', 150);
            $table->string('nmprovider', 150);
            $table->string('kodekelas', 150);
            $table->string('kelas', 150);
            $table->string('statuspesertakode', 150);
            $table->string('statuspesertaketerangan', 150);
            $table->string('jenispesertakode', 150);
            $table->string('jenispesertaketerangan', 150);

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
