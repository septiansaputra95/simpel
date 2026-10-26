<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MUserSIMRS extends Model
{
    //
    protected $table = 'm_user_s_i_m_r_s';

    // Tentukan primary key custom
    protected $primaryKey = 'user_id';

    // Set false jika user_id berupa string/teks (bukan angka auto-increment)
    public $incrementing = false; 
    
    // Tipe data primary key
    protected $keyType = 'string';

    // Mapping custom timestamp bawaan Laravel ke kolom buatanmu
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'modified_date';

    // Kolom-kolom yang diizinkan untuk diisi secara massal (mass assignment)
    protected $fillable = [
        'user_id',
        'user_name',
        'name',
        'id_role',
        'employee_type',
        'notes',
        'password_expired',
        'on_hold',
        'current_order_location',
        'default_order_location',
        'default_execution_location',
        'created_by',
        'modified_by',
        'specialization',
        'off_hours_flag',
    ];
}
