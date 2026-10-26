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
        Schema::create('m_scheduled_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('action_type', 50);
            $table->jsonb('payload');
            $table->timestamp('scheduled_at');
            $table->string('status', 20)->default('PENDING');
            $table->timestamp('executed_at')->nullable();
            $table->text('error_log')->nullable();
            $table->string('created_by', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_scheduled_tasks');
    }
};
