<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MRujukanPasien extends Model
{
    //
    protected $table = 'm_rujukan_pasiens';
    protected $primaryKey = 'id';
    protected $fillable = [
        'asal_faskes',
        'no_kunjungan',
        'tgl_kunjungan',
        'kd_perujuk',
        'nm_perujuk',
        'no_kartu',
        'nik',
        'nama_peserta',
        'pisa',
        'sex',
        'no_mr',
        'no_telepon',
        'tgl_lahir',
        'status_peserta_kode',
        'status_peserta_ket',
        'jenis_peserta_kode',
        'jenis_peserta_ket',
        'hak_kelas_kode',
        'hak_kelas_ket',
        'umur_sekarang',
        'prolanis_prb',
        'diagnosa_kode',
        'diagnosa_nama',
        'keluhan',
        'poli_rujukan_kode',
        'poli_rujukan_nama',
        'pelayanan_kode',
        'pelayanan_nama'
    ];
}