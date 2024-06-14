<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardCriteria extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id', 
        'standard_categories_id',
        'title'
    ];

    public function category()
    {
        return $this->belongsTo(StandardCategory::class, 'standard_categories_id');
    }
}
