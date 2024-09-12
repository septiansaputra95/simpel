<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MReferensiDokter extends Model
{
    use HasFactory;

    protected $primaryKey = "kodedokter";

    protected $fillable = [
        'kodedokter',
        'namadokter'
    ];
}
