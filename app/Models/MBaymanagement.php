<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MBaymanagement extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'norm',
        'namapasien',
        'kapasitaspasien',
        'dokter',
        'nomorantrian',
        'tanggal_data'
    ];
}
