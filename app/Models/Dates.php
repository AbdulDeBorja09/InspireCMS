<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dates extends Model
{
    protected $table = 'blocked_dates';
    protected $fillable = [
        'title',
        'service_id',
        'start_date',
        'end_date',

    ];
}
