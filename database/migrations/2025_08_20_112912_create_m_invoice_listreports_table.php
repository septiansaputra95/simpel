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
        Schema::create('m_invoice_listreports', function (Blueprint $table) {
            $table->id();

            $table->string('patient_name', 150)->nullable();
            $table->string('mrno', 150)->nullable();
            $table->string('admission_no', 150)->nullable();
            $table->string('visit_type', 150)->nullable();
            $table->string('invoice_no', 150)->nullable();
            $table->string('invoice_date', 150)->nullable();
            $table->string('invoice_status', 150)->nullable();
            $table->string('approved_date', 150)->nullable();
            $table->string('approved_by', 150)->nullable();
            $table->string('sponsor_amount', 150)->nullable();
            $table->string('patient_amount', 150)->nullable();
            $table->string('discretionary_patient_discount_amount', 150)->nullable();
            $table->string('tax_amount', 150)->nullable();
            $table->string('total_invoice_amount', 150)->nullable();
            $table->string('net_amount_before_tax', 150)->nullable();
            $table->string('net_amount', 150)->nullable();
            $table->string('paid_amount', 150)->nullable();
            $table->string('sponsor_discount_amount', 150)->nullable();
            $table->string('non_discretionary_patient_discount_amount', 150)->nullable();
            $table->string('emp_no', 150)->nullable();
            $table->string('emp_name_user', 150)->nullable();
            $table->string('service_center', 150)->nullable();
            $table->string('created_by_user', 150)->nullable();
            $table->string('payment_mode', 150)->nullable();
            $table->string('doctor_name', 150)->nullable();
            $table->string('updated_by', 150)->nullable();
            $table->string('remarks', 150)->nullable();
            $table->string('sponsor_name', 150)->nullable();
            $table->string('plan_name', 150)->nullable();
            $table->string('associate_company', 150)->nullable();
            $table->date('tanggaldata')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_invoice_listreports');
    }
};
