<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MKategori extends Model
{
    //
    protected $table = 'm_kategoris';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_kategori',
        'nama_kategori'
    ];
}
