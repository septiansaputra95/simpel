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
        Schema::create('m_permintan_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kode_permintaan')->constrained('m_permintaan_headers')->cascadeOnDelete();
            $table->integer('level');
            $table->string('role');
            $table->foreignId('unit_id')->nullable()->constrained('m_units')->nullOnDelete();
            $table->foreignId('approver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status',['pending','approved','rejected'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_permintan_approvals');
    }
};
