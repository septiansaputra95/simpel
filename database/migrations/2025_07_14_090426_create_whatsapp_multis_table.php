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
        Schema::create('whatsapp_multis', function (Blueprint $table) {
            $table->id();
            $table->string('wa_no', 150)->nullable();
            $table->string('wa_text', 150)->nullable();
            $table->string('wa_media', 150)->nullable();
            $table->boolean('wa_kirim')->default(0);
            $table->string('wa_note', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_multis');
    }
};
