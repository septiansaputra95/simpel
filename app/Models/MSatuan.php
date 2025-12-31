<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MSatuan extends Model
{
    //
    protected $table = 'm_satuans';

    protected $fillable = [
        'kode_satuan',
        'nama_satuan'
    ];


    public function gudangStok()
    {
        return $this->hasMany(MGudangStok::class, 'kode_satuan', 'kode_satuan');
    }

    public function masterbarang()
    {
        return $this->hasMany(MMasterBarang::class, 'kode_satuan', 'kode_satuan');
    }

}
