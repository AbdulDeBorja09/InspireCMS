<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'page_section';
    protected $fillable = ['name'];
    public function contents()
    {
        return $this->hasMany(Contents::class);
    }
}
