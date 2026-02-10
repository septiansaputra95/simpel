<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MStockCard extends Model
{

    protected $table = 'm_stock_cards';
    //
    protected $fillable = [
    'transaction_date',
    'transaction_id',
    'item_code',
    'item_name',
    'unit_stock',
    'transaction_no',
    'transaction_type',
    'balance_before',
    'qty',
    'qty_signed',
    'balance_after',
    'chronic',
    'order_priority',
    'batch_number',
    'expired_date',
    'order_location',
    'execution_location',
    'to_location_receiving',
    'billing_no',
    'treatment_type',
    'mr_no_or_vendor_code',
    'date_of_birth',
    'patient_name_or_vendor_name',
    'home_address',
    'guarantor',
    'episode_location',
    'price',
    'amount',
    'note_or_doctor_name',
    'acknowledged',
    'created_by',
    'created_date',
    'modified_by',
    'modified_date',
    ];


    protected $casts = [
    'transaction_date' => 'datetime',
    'expired_date' => 'date',
    'date_of_birth' => 'date',
    'created_date' => 'datetime',
    'modified_date' => 'datetime',
    'chronic' => 'boolean',
    'acknowledged' => 'boolean',
    'price' => 'decimal:2',
    'amount' => 'decimal:2',
    ];

}
