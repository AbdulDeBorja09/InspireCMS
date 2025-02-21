<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqsQuestions extends Model
{
    protected $table = 'faq_questions';
    protected $fillable = [
        'id',
        'category_id',
        'question',
        'answer'
    ];

    public function category()
    {
        return $this->belongsTo(FaqsCategory::class);
    }
}
