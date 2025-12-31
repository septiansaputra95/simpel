<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MJenisBarang extends Model
{
    //
    protected $table = 'm_jenis_barangs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_jenis_barang',
        'nama_jenis_barang'
    ];
}
