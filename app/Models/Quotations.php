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
        'date_time',
        'serive_type',
        'serive_name',
        'Description',
        'qty',
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
