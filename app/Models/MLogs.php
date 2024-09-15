<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MLogs extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'metode',
        'api',
        'controller',
        'code',
        'message',
        'data'
    ];
}
