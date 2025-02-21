<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $table = 'articles';
    protected $fillable = [
        'title',
        'author',
        'date',
        'image',
        'description',
        'redirect_url',
        'url1',
        'url2',
        'url3',
        'url4',
        'redirect',
    ];
}
