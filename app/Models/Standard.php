<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id', 'title', 'weight', 'question_category_id','status'
    ];

    public function category()
    {
        return $this->belongsTo(QuestionCategory::class, 'question_category_id');
    }
}
