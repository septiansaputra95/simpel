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
        Schema::create('m_whatsapp_outboxes', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_number', 20); // Nomor tujuan
            $table->text('message_body');           // Isi pesan
            $table->string('media_url')->nullable(); // Media (opsional)
            
            // Status untuk antrean (Queue)
            $table->string('status')->default('pending'); // pending, processing, sent, failed
            $table->integer('retries')->default(0);
            
            // Logging
            $table->text('last_error')->nullable();
            $table->timestamp('sent_at')->nullable();            

            $table->timestamps();

            // Indexing agar pencarian status 'pending' cepat
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_whatsapp_outboxes');
    }
};
