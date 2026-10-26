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
        Schema::create('m_user_s_i_m_r_s', function (Blueprint $table) {
            $table->id();
            // Gunakan string jika user_id berupa teks (misal: "USR001"), 
            // atau ganti jadi $table->id('user_id') jika berupa angka Auto Increment
            $table->string('user_id')->prinullablemary(); 
            
            $table->string('user_name')->nullable();
            $table->string('name');
            $table->string('id_role')->nullable();
            $table->string('employee_type')->nullable();
            $table->text('notes')->nullable();
            $table->date('password_expired');
            $table->boolean('on_hold')->default(false);
            $table->string('current_order_location')->nullable();
            $table->string('default_order_location')->nullable();
            $table->string('default_execution_location')->nullable();
            
            // Custom Timestamp
            $table->timestamp('created_date')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamp('modified_date')->nullable();
            $table->string('modified_by')->nullable();
            
            $table->string('specialization')->nullable();
            $table->boolean('off_hours_flag')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_user_s_i_m_r_s');
    }
};
