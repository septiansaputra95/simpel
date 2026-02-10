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
        Schema::create('m_permintaan_headers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_permintaan')->unique();
            $table->date('tanggal_permintaan');
            $table->foreignId('user_id')->constrained('users')->nullOnDelete();
            $table->foreignId('unit_id')->constrained('m_units')->nullOnDelete();
            $table->enum('status', ['draft','proses','disetujui','ditolak'])->default('draft');
            $table->integer('current_level')->default(0);
            $table->integer('total_item')->default(0);
            $table->integer('total_qty')->default(0);
            $table->decimal('total_harga',15,2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_permintaan_headers');
    }
};
