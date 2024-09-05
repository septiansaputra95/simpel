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
        Schema::create('m_task_lists', function (Blueprint $table) {
            $table->id();
            $table->string('kodebooking', 150);
            $table->string('wakturs');
            $table->string('waktu', 150);
            $table->string('taskname', 150);
            $table->string('taskid', 150);
            $table->date('tanggal_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_task_lists');
    }
};
