<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    protected $table = 'layout';
    protected $fillable = [
        'type',
        'key',
        'value'
    ];
}
