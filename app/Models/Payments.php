<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'quotation_id',
        'payment_term',
        'name',
        'address',
        'email',
        'phone',
        'proof',

    ];
}
