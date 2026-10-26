<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MScheduledTask extends Model
{
    //
    protected $table = 'm_scheduled_tasks';

    protected $fillable = [
        'action_type',
        'payload',
        'scheduled_at',
        'status',
        'executed_at',
        'error_log',
        'created_by',
    ];

    // Casting tipe data agar Laravel otomatis mengubah JSONB menjadi array
    // dan mengatur format timestamp saat digunakan
    protected $casts = [
        'payload' => 'array',
        'scheduled_at' => 'datetime',
        'executed_at' => 'datetime',
    ];
}
