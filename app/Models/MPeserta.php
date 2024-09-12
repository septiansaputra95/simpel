<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPeserta extends Model
{
    use HasFactory;

    protected $primaryKey = "nik";

    protected $fillable = [
        'nik',
        'nama',
        'noKartu',
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
}
