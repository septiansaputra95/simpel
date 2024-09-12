<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MJadwalDokter extends Model
{
    use HasFactory;

    protected $primaryKey = "kodesubspesialis";

    protected $fillable = [
        'kodesubspesialis',
        'hari',
        'kapasitaspasien',
        'libur',
        'namahari',
        'jadwal',
        'namasubspesialis',
        'namadokter',
        'kodepoli',
        'namapoli',
        'kodedokter',
        'tanggal_data'
    ];
}
