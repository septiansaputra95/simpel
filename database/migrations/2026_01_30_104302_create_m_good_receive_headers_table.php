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
        Schema::create('m_good_receive_headers', function (Blueprint $table) {
            $table->id();

            $table->string('docket_number')->unique();
            $table->date('docket_date')->nullable();
            $table->date('receive_date')->nullable();
            $table->string('vendor_code')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('location')->nullable();
            $table->string('location_code')->nullable();
            $table->string('delivery_order_no')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('exchange_rate', 15, 4)->nullable();
            $table->boolean('completed')->default(false);
            $table->time('time')->nullable();
            $table->dateTime('process_time')->nullable();
            $table->string('transaction_user')->nullable();
            $table->unsignedBigInteger('id_location')->nullable();
            $table->string('source_file_name')->nullable();
            $table->boolean('pengecekan')->default(false);

            // $table->string('docket_number', 50)->nullable();
            // $table->dateTime('docket_date')->nullable();
            // $table->string('delivery_order_no', 50)->nullable();
            // $table->dateTime('receive_date')->nullable();
            // $table->string('producer_key', 50)->nullable();
            // $table->decimal('currency', 15, 2)->nullable();
            // $table->integer('exchange_rate')->nullable();
            // $table->boolean('completed')->nullable();
            // $table->dateTime('time')->nullable();
            // $table->string('transaction_user', 100)->nullable();
            // $table->integer('id_lokasi')->nullable();
            // $table->integer('partner_key')->nullable();
            // $table->string('partner_name', 100)->nullable();
            // $table->string('source_file', 100)->nullable();
            // $table->dateTime('entered_date')->nullable();
            // $table->string('data_area_id', 10)->nullable();
            // $table->boolean('pengecekan')->default(false);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_good_receive_headers');
    }
};
