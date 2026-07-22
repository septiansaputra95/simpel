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
        Schema::create('m_statistik_i_g_d_s', function (Blueprint $table) {
            $table->id();
            // Data Pasien & Kunjungan
            // Data Pasien & Kunjungan
            $table->text('no')->nullable();
            $table->text('tanggal')->nullable();
            $table->text('mrn')->nullable();
            $table->text('nama_pasien')->nullable();
            $table->boolean('b')->default(false);
            $table->boolean('l_1')->default(false);
            $table->text('usia')->nullable();
            $table->text('tipe_pasien')->nullable();
            $table->text('jaminan')->nullable();
            $table->boolean('l_2')->default(false);
            $table->boolean('p')->default(false);
            
            // Waktu & Triase
            $table->text('jd')->nullable();
            $table->text('rt')->nullable();
            $table->text('jt')->nullable();
            $table->text('los')->nullable();
            $table->boolean('i_1')->default(false);
            $table->boolean('i_2')->default(false);
            $table->boolean('ii')->default(false);
            $table->boolean('iii')->default(false);
            $table->boolean('iv')->default(false);
            $table->boolean('v')->default(false);
            $table->text('asal_rujukan')->nullable();

            // Pemeriksaan & Tindakan
            $table->boolean('ekg')->default(false);
            $table->boolean('nebul')->default(false);
            $table->boolean('lab')->default(false);
            $table->boolean('ro')->default(false);
            $table->boolean('resep')->default(false);
            $table->boolean('ag')->default(false);
            $table->boolean('dc')->default(false);
            $table->boolean('ngt')->default(false);
            $table->boolean('intubasi')->default(false);
            $table->text('diagnosa')->nullable();
            $table->text('tindakan')->nullable();
            $table->text('pemasangan_infus')->nullable();
            
            // Petugas Medis
            $table->text('dokter')->nullable();
            $table->text('perawat')->nullable();
            
            // Status Keluar & Ruangan
            $table->boolean('triage_ps_rj')->default(false);
            $table->boolean('plg')->default(false);
            $table->boolean('rujuk')->default(false);
            $table->boolean('aps')->default(false);
            $table->boolean('odc')->default(false);
            $table->boolean('rwi')->default(false);
            $table->boolean('rwi_ok')->default(false);
            $table->boolean('rwi_vk')->default(false);
            $table->boolean('rwi_intensif')->default(false);
            $table->boolean('meninggal')->default(false);
            $table->boolean('igd_biasa')->default(false);
            $table->boolean('igd_isolasi')->default(false);
            $table->boolean('igd_ponek')->default(false);
            
            // Lain-lain
            $table->boolean('cash_sarungtangan_dll')->default(false);
            $table->text('dpjp')->nullable();
            $table->text('penyebab_los_lebih_2_jam')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_statistik_i_g_d_s');
    }
};
