<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MGudangStok extends Model
{
    //
    protected $table = 'm_gudang_stoks';

    protected $fillable = [
        'gudang_id',
        'barang_id',
        'kode_gudang',
        'kode_barang',
        'batch_barang',
        'kode_satuan',
        'expired_date',
        'harga_barang',
        'stok_barang',
        'is_active'
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
