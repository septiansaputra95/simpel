<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MReferensiFaskes extends Model
{
    //
    protected $table = 'm_referensi_faskes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode',
        'nama'
    ];
}