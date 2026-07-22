<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_rujukan_pasiens', function (Blueprint $table) {
            $table->id();

            $table->string('asal_faskes')->nullable();
            $table->string('no_kunjungan')->nullable();
            $table->date('tgl_kunjungan')->nullable();

            // Perujuk
            $table->string('kd_perujuk')->nullable();
            $table->string('nm_perujuk')->nullable();

            // Data Peserta
            $table->string('no_kartu')->nullable();
            $table->string('nik')->nullable();
            $table->string('nama_peserta')->nullable();
            $table->string('pisa')->nullable();
            $table->char('sex', 1)->nullable();
            $table->string('no_mr')->nullable();
            $table->string('no_telepon')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->date('tgl_cetak_kartu')->nullable();
            $table->date('tgl_tat')->nullable();
            $table->date('tgl_tmt')->nullable();

            // Status & Jenis Peserta
            $table->string('status_peserta_kode')->nullable();
            $table->string('status_peserta_ket')->nullable();
            $table->string('jenis_peserta_kode')->nullable();
            $table->string('jenis_peserta_ket')->nullable();
            $table->string('hak_kelas_kode')->nullable();
            $table->string('hak_kelas_ket')->nullable();

            // Provider Umum (Faskes Tingkat 1)
            $table->string('kd_provider_umum')->nullable();
            $table->string('nm_provider_umum')->nullable();

            // Umur
            $table->string('umur_sekarang')->nullable();
            $table->string('umur_saat_pelayanan')->nullable();

            // Informasi Tambahan
            $table->string('prolanis_prb')->nullable();
            $table->string('no_sktm')->nullable();

            // Diagnosa & Poli
            $table->string('diagnosa_kode')->nullable();
            $table->string('diagnosa_nama')->nullable();
            $table->text('keluhan')->nullable();
            $table->string('poli_rujukan_kode')->nullable();
            $table->string('poli_rujukan_nama')->nullable();

            // Pelayanan
            $table->string('pelayanan_kode')->nullable();
            $table->string('pelayanan_nama')->nullable();

            $table->date('tanggal_antrian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_rujukan_pasiens');
    }
};