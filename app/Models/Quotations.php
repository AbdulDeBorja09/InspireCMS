<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotations extends Model
{
    protected $table = 'quotations';

    protected $fillable = [
        'Quotation_ref',
        'billing_name',
        'billing_address',
        'service_type',
        'items',
        'start_date',
        'end_date',
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
