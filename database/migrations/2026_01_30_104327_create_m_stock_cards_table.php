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
        Schema::create('m_stock_cards', function (Blueprint $table) {
            $table->id();

            $table->dateTime('transaction_date')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->string('unit_stock')->nullable();
            $table->string('transaction_no')->nullable()->index();
            $table->string('transaction_type')->nullable();
            $table->decimal('balance_before', 15, 2)->nullable();
            $table->decimal('qty', 15, 2)->nullable();
            $table->decimal('qty_signed', 15, 2)->nullable();
            $table->decimal('balance_after', 15, 2)->nullable();
            $table->boolean('chronic')->nullable();
            $table->string('order_priority')->nullable();
            $table->string('batch_number')->nullable();
            $table->date('expired_date')->nullable();
            $table->string('order_location')->nullable();
            $table->string('execution_location')->nullable();
            $table->string('to_location_receiving')->nullable();
            $table->string('billing_no')->nullable();
            $table->string('treatment_type')->nullable();
            $table->string('mr_no_or_vendor_code')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('patient_name_or_vendor_name')->nullable();
            $table->text('home_address')->nullable();
            $table->string('guarantor')->nullable();
            $table->string('episode_location')->nullable();
            $table->decimal('price', 18, 2)->nullable();
            $table->decimal('amount', 18, 2)->nullable();
            $table->string('note_or_doctor_name')->nullable();
            $table->boolean('acknowledged')->nullable();
            $table->string('created_by')->nullable();
            $table->string('created_date')->nullable();
            $table->string('modified_by')->nullable();
            $table->string('modified_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_stock_cards');
    }
};
