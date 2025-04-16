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
        Schema::create('m_discharge_reports', function (Blueprint $table) {
            $table->id();
            $table->string('mrn', 150)->nullable();
            $table->string('patientname', 150)->nullable();
            $table->string('mobileno', 150)->nullable();
            $table->string('district', 150)->nullable();
            $table->string('admissionnote', 150)->nullable();
            $table->string('kelas', 150)->nullable();
            $table->string('umur', 150)->nullable();
            $table->string('admissiondate', 150)->nullable();
            $table->string('dischargedate', 150)->nullable();
            $table->date('tanggaldata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_discharge_reports');
    }
};
