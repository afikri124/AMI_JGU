<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubIndicator extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'name',
        'standard_criterias_id',
        'indicator_id'
    ];

    public function getKeyType()
    {
        return 'string';
    }

    public function criteria()
    {
        return $this->belongsTo(StandardCriteria::class, 'standard_criterias_id');
    }

    // public function indicator()
    // {
    //     return $this->belongsTo(Indicator::class, 'indicator_id');
    // }
    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }

}
