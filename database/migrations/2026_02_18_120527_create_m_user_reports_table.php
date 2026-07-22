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
        Schema::create('m_user_reports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('whatsapp_number');
            $table->string('apps_name');
            
            // Kolom Tambahan Objektif
            $table->time('send_at')->default('08:00')->nullable(); // Kapan bot harus kirim?
            $table->boolean('is_active')->default(true); // User bisa berhenti langganan sementara
            $table->timestamp('last_sent_at')->nullable(); // Menghindari spam/double kirim
            $table->string('status_terakhir')->nullable(); // Misal: "Success" atau "Failed: Connection Error"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_user_reports');
    }
};
