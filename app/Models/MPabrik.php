<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MPabrik extends Model
{
    //
    protected $table = 'm_pabriks';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_pabrik',
        'nama_pabrik'
    ];
}
