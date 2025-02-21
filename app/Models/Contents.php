<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contents extends Model
{
    protected $table = 'page_content';
    protected $fillable = [
        'section_id',
        'key',
        'value',
        'type'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
