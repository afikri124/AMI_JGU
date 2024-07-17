<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewDocs extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id', 'name', 'indicator_id', 'standard_criteria_id'
    ];

    public function criteria()
    {
        return $this->belongsTo(StandardCriteria::class, 'standard_criteria_id');
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }
}
