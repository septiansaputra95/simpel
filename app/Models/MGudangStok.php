<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MGudangStok extends Model
{
    //
    protected $table = 'm_gudang_stoks';

    protected $fillable = [
        'kode_gudang',
        'kode_barang',
        'batch_barang',
        'expired_date',
        'harga_barang',
        'stok_barang'
    ];

    public function gudang()
    {
        return $this->belongsTo(MMasterGudang::class, 'kode_gudang', 'kode_gudang');
    }

    public function barang()
    {
        return $this->belongsTo(MMasterBarang::class, 'kode_barang', 'kode_barang');
    }
    
    public function satuan()
    {
        return $this->belongsTo(MSatuan::class, 'kode_satuan', 'kode_satuan');
    }
    
}
