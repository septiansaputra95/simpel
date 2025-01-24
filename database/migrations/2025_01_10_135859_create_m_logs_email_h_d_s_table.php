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
        Schema::create('m_logs_email_h_d_s', function (Blueprint $table) {
            $table->id();
            $table->string('idpengiriman', 150);
            $table->string('kodedokter', 150);
            $table->string('emaildokter', 150);
            $table->date('tanggalawal');
            $table->date('tanggalakhir');
            $table->boolean('statuspengiriman');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_logs_email_h_d_s');
    }
};
