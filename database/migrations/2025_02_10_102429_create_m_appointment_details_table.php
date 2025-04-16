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
        Schema::create('m_appointment_details', function (Blueprint $table) {
            $table->id();
            $table->string('no_mrn', 150)->nullable();
            $table->string('patient_name', 150)->nullable();
            $table->string('gender', 150)->nullable();
            $table->string('mobile_no', 150)->nullable();
            $table->string('address_no', 150)->nullable();
            $table->string('city', 150)->nullable();
            $table->string('resource', 150)->nullable();
            $table->string('departement_name', 150)->nullable();
            $table->string('unit_name', 150)->nullable();
            $table->string('slot', 150)->nullable();
            $table->string('status', 150)->nullable();
            $table->string('created_by', 150)->nullable();
            $table->date('tanggal_data');
            $table->string('data_id', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_appointment_details');
    }
};
