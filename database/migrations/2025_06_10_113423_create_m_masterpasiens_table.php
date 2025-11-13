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
        Schema::create('m_masterpasiens', function (Blueprint $table) {
            $table->id();
            $table->string('mrn', 150)->nullable();
            $table->string('patientname', 150)->nullable();
            $table->string('gender', 150)->nullable();
            $table->date('dateofbirth')->nullable();
            $table->string('registrationtype', 150)->nullable();
            // $table->string('registrationdate', 150)->nullable();
            $table->date('registrationdate')->nullable();
            $table->string('mobileno', 150)->nullable();
            $table->string('maritalstatus', 150)->nullable();
            $table->string('religion', 150)->nullable();
            $table->string('nationality', 150)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('phoneno', 150)->nullable();
            $table->string('city', 150)->nullable();
            $table->string('district', 150)->nullable();
            $table->string('state', 150)->nullable();
            $table->string('country', 150)->nullable();
            $table->string('identitytype', 150)->nullable();
            $table->string('identityno', 150)->nullable();
            $table->string('emergencycontactperson', 150)->nullable();
            $table->string('relationship', 150)->nullable();
            $table->string('emergencyphoneno', 150)->nullable();
            $table->string('planname', 150)->nullable();
            $table->string('user', 150)->nullable();
            $table->string('servicecenter', 150)->nullable();
            // $table->date('tanggaldata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_masterpasiens');
    }
};
