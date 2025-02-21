<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqsCategory extends Model
{

    protected $table = 'Faqs_category';
    protected $fillable = [
        'name',
    ];
    public function faqs()
    {
        return $this->hasMany(FaqsQuestions::class, 'category_id');
    }
}
