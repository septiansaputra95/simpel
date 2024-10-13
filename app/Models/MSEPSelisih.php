<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSEPSelisih extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'nosep',
        'tglsep', 
        'kelasrawat',
        'diagnosa',
        'kodebooking',
        'norujukan',
        'poli',
        'nokartu',
        'nama',
        'nomr',
        'kddpjp',
        'nmdpjp',
        'flagdatang',
        'flagaddantrean'
    ];

    public function peserta()
    {
        return $this->hasMany(MPeserta::class, 'noKartu', 'nokartu');
    }
}
