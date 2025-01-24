<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFileHonorDokter extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $tabel = 'm_file_honor_dokters';

    protected $fillable = [
        'idpengiriman',
        'kodedokter',
        'file'
    ];
}
