<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListDocument extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'name',
        'standard_criterias_id',
        'indicator_id',
        'sub_indicators_id'
    ];

    public function sub()
    {
        return $this->belongsTo(SubIndicator::class, 'sub_indicators_id');
    }
}
