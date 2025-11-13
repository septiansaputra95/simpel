<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MTanggalSuratKontrol extends Model
{
    //
    protected $primaryKey = "id";

    protected $fillable = [
        'nosuratkontrol',
        'jenispelayanan',
        'jeniskontrol',
        'namajeniskontrol',
        'tglrencanankontrol',
        'nosepasalkontrol',
        'poliasal',
        'namapoliasal',
        'politujuan',
        'namapolitujuan',
        'tglsep',
        'kodedokter',
        'namadokter',
        'nokartu',
        'nama',
        'terbitsep'
    ];
}
