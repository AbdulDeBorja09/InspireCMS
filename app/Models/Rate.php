<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $table = 'service_rates';

    protected $fillable = [
        'service_id',
        'rate_type',
        'rate',
        'unit',
        'hour',
        'inclusions'
    ];

    public function facility()
    {
        return $this->belongsTo(Services::class);
    }
}
