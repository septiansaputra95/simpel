<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MMasterBarang extends Model
{
    use HasFactory;
    protected $primaryKey = "kode_barang";

    protected $fillable = [
        'kode_barang',
        'nama_barang', 
        'harga_barang', 
        'kode_satuan'
    ];
}
