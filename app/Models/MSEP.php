<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSEP extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'nosep',
        'tglsep', 
        'kelasrawat',
        'diagnosa',
        'norujukan',
        'poli',
        'nokartu',
        'nama',
        'nomr',
        'kddpjp',
        'nmdpjp'

    ];

}
