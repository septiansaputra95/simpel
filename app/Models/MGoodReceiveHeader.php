<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MGoodReceiveHeader extends Model
{
    //
    protected $table = 'm_good_receive_headers';

    protected $fillable = [
    'docket_number',
    'docket_date',
    'receive_date',
    'vendor_code',
    'vendor_name',
    'location',
    'location_code',
    'delivery_order_no',
    'currency',
    'exchange_rate',
    'completed',
    'time',
    'process_time',
    'transaction_user',
    'id_location',
    'source_file_name',
    ];


    protected $casts = [
    'completed' => 'boolean',
    'docket_date' => 'date',
    'receive_date' => 'date',
    'process_time' => 'datetime',
    ];
}
