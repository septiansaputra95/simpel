<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPeserta extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'nik',
        'nama',
        'noKartu',
        'noMr',
        'noTelepon',
        'pisa',
        'kdprovider',
        'nmprovider',
        'kodekelas',
        'kelas',
        'statuspesertaketerangan',
        'statuspesertakode',
        'jenispesertakode',
        'jenispesertaketerangan'
    ];

    public function SEPselisih()
    {
        return $this->belongsTo(MSEPSelisih::class, 'nokartu', 'noKartu');
    }
}
