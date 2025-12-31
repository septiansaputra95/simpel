<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MKelompokObat extends Model
{
    //
    protected $table = 'm_kelompok_obats';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_kelompok',
        'nama_kelompok'
    ];
}
