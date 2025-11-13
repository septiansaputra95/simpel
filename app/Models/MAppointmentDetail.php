<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MAppointmentDetail extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'no_mrn',
        'patient_name',
        'gender',
        'mobile_no',
        'address_no',
        'city',
        'resource',
        'departement_name',
        'unit_name',
        'slot',
        'status',
        'created_by',
        'tanggal_data',
        'data_id',
        'nama'
    ];

    public function peserta()
    {
        return $this->belongsTo(MPeserta::class, 'no_mrn', 'noMr');
    }
}
