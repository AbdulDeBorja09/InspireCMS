<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';
    protected $fillable = [
        'type',
        'image1',
        'image2',
        'image3',
        'image4',
        'name',
        'description',
        'brief',

    ];


    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
}
