<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notifications extends Model
{
    protected $table = 'notifications';
    protected $fillable = [
        'user_id',
        'quotation_id',
        'message',
        'status',
    ];

    public function request()
    {
        return $this->belongsTo(Quotations::class, 'quotation_id');
    }
}
