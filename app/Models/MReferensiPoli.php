<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MReferensiPoli extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'kdpoli',
        'kdsubspesialis',
        'nmpoli',
        'nmsubspesialis'
    ];
}
