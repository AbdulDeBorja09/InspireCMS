<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'phone',
        'message'
    ];
}
