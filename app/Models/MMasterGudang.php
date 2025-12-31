<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MMasterGudang extends Model
{
    //
    protected $table = 'm_master_gudangs';

    protected $fillable = [
        'kode_gudang',
        'nama_gudang',
        'unitid',
        'penanggung_jawab',
        'is_active'
    ];

    public function stokBarang()
    {
        return $this->hasMany(GudangStok::class, 'kode_gudang', 'kode_gudang');
    }

}
