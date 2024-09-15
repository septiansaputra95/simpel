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
        Schema::create('m_logs', function (Blueprint $table) {
            $table->id();
            $table->string('metode', 150);
            $table->string('api', 150);
            $table->string('controller', 150);
            $table->string('code', 150);
            $table->string('message', 150);
            $table->string('data', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_logs');
    }
};
