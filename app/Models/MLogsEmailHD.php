<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MLogsEmailHD extends Model
{
    use HasFactory;
    
    protected $primaryKey = "id";
    protected $tabel = 'm_logs_email_h_d_s';

    protected $fillable = [
        'idpengiriman',
        'kodedokter',
        'emaildokter',
        'tanggalawal', 
        'tanggalakhir', 
        'statuspengiriman'
    ];
}
