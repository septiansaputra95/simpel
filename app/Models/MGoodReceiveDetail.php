<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MGoodReceiveDetail extends Model
{
    //
    protected $table = 'm_good_receive_details';

    protected $fillable = [
    'transaction_date',
    'transaction_no',
    'location_name',
    'vendor_code',
    'vendor_name',
    'item_code',
    'item_name',
    'batch_number',
    'unit_stock',
    'expired_date',
    'item_qty_location_balance',
    'qty',
    'cost_price',
    'notes',
    'created_by',
    'create_date',
    ];


    protected $casts = [
    'transaction_date' => 'date',
    'expired_date' => 'date',
    'create_date' => 'date',
    'cost_price' => 'decimal:3',
    ];
}
