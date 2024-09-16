<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MTaskList extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'kodebooking',
        'wakturs', 
        'waktu', 
        'taskname',
        'taskid',
        'tanggal_data'
    ];

    public function antrian()
    {
        return $this->belongsTo(MAntrianTanggal::class, 'kodebooking', 'kodebooking');
    }
}
