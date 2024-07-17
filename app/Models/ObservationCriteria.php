<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservationCriteria extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id',
        'observation_id',
        'observation_category_id',
    ];

}
