<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MMasterDokter extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = 'm_master_dokters';

    protected $fillable = [
        'kodedokter',
        'namadokter', 
        'emaildokter', 
        'nomorhp'
    ];

    public function pengirimanHonor()
    {
        return $this->hasMany(MPengirimanHonor::class, 'kodedokter', 'kodedokter');
    }
}
