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
        Schema::create('m_good_receive_details', function (Blueprint $table) {
            $table->id();

            $table->date('transaction_date')->nullable();
            $table->string('transaction_no')->index();
            $table->string('location_name')->nullable();
            $table->string('vendor_code')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->string('batch_number')->nullable();
            $table->string('unit_stock')->nullable();
            $table->date('expired_date')->nullable();
            $table->integer('item_qty_location_balance')->default(0);
            $table->integer('qty')->default(0);
            $table->decimal('cost_price', 15, 3)->default(0);
            $table->string('notes')->nullable();
            $table->string('created_by')->nullable();
            $table->date('create_date')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_good_receive_details');
    }
};
