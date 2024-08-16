<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'name',
        'standard_criteria_id',
        'standard_statement_id'
    ];

    public function getKeyType()
    {
        return 'string';
    }

    public function criteria()
    {
        return $this->belongsTo(StandardCriteria::class, 'standard_criteria_id');
    }

    public function statement()
    {
        return $this->belongsTo(StandardStatement::class, 'standard_statement_id');
    }

    public function obs_c()
    {
        return $this->belongsTo(ObservationChecklist::class, 'indicator_id');
    }

    public function rtm()
    {
        return $this->hasMany(Rtm::class, 'indicator_id');
    }
}
