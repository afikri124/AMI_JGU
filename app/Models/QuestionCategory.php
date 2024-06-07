<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id', 'title', 'description', 'is_required','status'
    ];

    public function standars()
    {
        return $this->hasMany(Standard::class);
    }

    

}
