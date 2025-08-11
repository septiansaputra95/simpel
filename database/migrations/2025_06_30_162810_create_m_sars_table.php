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
        Schema::create('m_sars', function (Blueprint $table) {
            $table->id();
            $table->string('invoiceno', 150)->nullable();
            $table->timestamp('date')->nullable();
            $table->string('admissionno', 150)->nullable();
            $table->timestamp('admissiondate')->nullable();
            $table->string('admittedfor', 150)->nullable();
            $table->string('visitno', 150)->nullable();
            $table->string('mrn', 150)->nullable();
            $table->string('patientname', 150)->nullable();
            $table->string('opiptype', 150)->nullable();
            $table->string('year', 150)->nullable();
            $table->string('month', 150)->nullable();
            $table->string('referencedepartementname', 150)->nullable();
            $table->string('referencedoctorname', 150)->nullable();
            $table->string('rendepartementname', 150)->nullable();
            $table->string('rendoctorname', 150)->nullable();
            $table->string('servicecode', 150)->nullable();
            $table->string('servicename', 150)->nullable();
            $table->string('servicegroup', 150)->nullable();
            $table->string('patienttype', 150)->nullable();
            $table->string('sponsor', 150)->nullable();
            $table->string('associatecompany', 150)->nullable();
            $table->string('gender', 150)->nullable();
            $table->float('servicegrossamount')->nullable();
            $table->float('taxamount')->nullable();
            $table->float('discretionaryconcession')->nullable();
            $table->float('nondiscretionaryconcession')->nullable();
            $table->float('servicenetamount')->nullable();
            $table->float('patientpayable')->nullable();
            $table->float('sponsorpayable')->nullable();
            $table->float('depositreceived')->nullable();
            $table->float('balancepatientamount')->nullable();
            $table->string('concauthbyname', 150)->nullable();
            $table->string('actionusername', 150)->nullable();
            $table->string('servicecategory', 150)->nullable();
            $table->integer('servicequantity')->nullable(); // perbaikan dari int()
            $table->string('servicetype', 150)->nullable();
            $table->string('invoicestatus', 150)->nullable();
            $table->timestamp('invoiceapproveddatetime')->nullable();
            $table->timestamp('dischargedatetime')->nullable();
            $table->string('billinggroup', 150)->nullable();
            $table->timestamp('servicerequested')->nullable();
            $table->timestamp('servicerendering')->nullable();
            $table->string('attendingdepartemenservicetrequest', 150)->nullable();
            $table->string('attendingdoctorservicerequest', 150)->nullable();
            $table->string('attendingdepartementservicerendering', 150)->nullable();
            $table->string('attendingdoctorservicerendering', 150)->nullable();
            $table->string('wardrequestservice', 150)->nullable();
            $table->string('wardrenderingservice', 150)->nullable();
            $table->float('hospitalunitrate')->nullable();
            $table->float('hospitaltotalamount')->nullable();
            $table->string('revenuedepartment', 150)->nullable();
            $table->string('revenuedoctor', 150)->nullable();
            $table->string('financegroup', 150)->nullable();
            $table->string('originialinvoice', 150)->nullable();
            $table->string('planname', 150)->nullable();
            $table->timestamp('actualorderdate')->nullable(); // perbaikan tipe dari string jadi timestamp
            $table->string('bedno', 150)->nullable();
            $table->string('bedtype', 150)->nullable();
            $table->string('orderservicecenter', 150)->nullable();
            $table->string('renderedservicecenter', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_sars');
    }
};
