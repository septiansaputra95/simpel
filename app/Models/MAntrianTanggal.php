<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MAntrianTanggal extends Model
{
    use HasFactory;

    protected $primaryKey = "kodebooking";

    protected $fillable = [
        'kodebooking',
        'tanggal', 
        'kodepoli', 
        'kodedokter',
        'nohp',
        'nokapst',
        'norekammedis',
        'jeniskunjungan',
        'nomorreferensi',
        'sumberdata',
        'noantrean',
        'estimasidilayani',
        'createdtime',
        'status'
    ];

    public function tasklist()
    {
        return $this->hasMany(MTaskList::class, 'kodebooking', 'kodebooking');
    }
}
