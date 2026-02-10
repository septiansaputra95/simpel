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
        Schema::create('m_units', function (Blueprint $table) {
            $table->id();
            $table->string('unitid', 150)->index()->unique();
            $table->string('unitnama', 150);
            $table->foreignId('parent_id')->nullable()->constrained('m_units')->nullOnDelete();
            $table->integer('limit_nominal')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_units');
    }
};
