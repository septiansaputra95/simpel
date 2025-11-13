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
        Schema::create('m_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable()->index(); // untuk submenu
            $table->string('name');       // Nama menu (contoh: Users, Master Dokter)
            $table->string('route')->nullable(); // nama route Laravel (contoh: user.index)
            $table->string('icon')->nullable();  // material icon / fontawesome
            $table->integer('order_no')->default(0); // urutan tampil
            $table->boolean('is_active')->default(true); // menu aktif / nonaktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_menus');
    }
};
