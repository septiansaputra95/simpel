<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPengirimanHonorDokter extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $tabel = 'm_pengiriman_honor_dokters';

    protected $fillable = [
        'kodedokter',
        'tanggalawal', 
        'tanggalakhir', 
        'file',
        'flagkirim'
    ];

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file);
    }

    public function dokter()
    {
        return $this->belongsTo(MMasterDokter::class, 'kodedokter', 'kodedokter');
    }

}
