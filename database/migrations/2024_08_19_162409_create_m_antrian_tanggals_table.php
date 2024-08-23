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
        Schema::create('m_antrian_tanggals', function (Blueprint $table) {
            $table->id();
            $table->string('kodebooking')->index()->unique();
            $table->date('tanggal');
            $table->string('kodepoli', 150);
            $table->string('kodedokter', 150);
            $table->string('nokapst', 150);
            $table->string('nohp', 150);
            $table->string('norekammedis', 150);
            $table->string('jeniskunjungan', 150);
            $table->string('nomorreferensi', 150);
            $table->string('sumberdata', 150);
            $table->string('noantrean', 150);
            $table->string('estimasidilayani', 150);
            $table->string('createdtime', 150);
            $table->string('status', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_antrian_tanggals');
    }
};
