<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotations extends Model
{
    protected $table = 'quotations';

    protected $fillable = [
        'user_id',
        'event_title',
        'Quotation_ref',
        'billing_name',
        'billing_address',
        'service_id',
        'service_type',
        'items',
        'date',
        'start_time',
        'end_time',
        'tax',
        'discount',
        'penalty',
        'Cancellation',
        'amount_paid',
        'balance',
        'total',
        'status'
    ];
}
