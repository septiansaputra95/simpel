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
        'nama_barang'
    ];

    public function stokGudang()
    {
        return $this->hasMany(MGudangStok::class, 'kode_barang', 'kode_barang');
    }
    
    public function satuan()
    {
        return $this->belongsTo(MSatuan::class, 'kode_satuan', 'kode_satuan');
    }
    

}
