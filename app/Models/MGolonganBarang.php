<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MGolonganBarang extends Model
{
    //
    protected $table = 'm_golongan_barangs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_golongan_barang',
        'nama_golongan_barang'
    ];
}
