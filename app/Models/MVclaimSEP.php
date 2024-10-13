<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MVclaimSEP extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor',
        'nomor_sep', 
        'nomor_rujukan',
        'tanggal_sep',
        'rirj',
        'nomor_kartu',
        'nama_peserta',
        'diagnosa',
        'poli'
    ];
}
