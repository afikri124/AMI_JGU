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
    ];

    public function getKeyType()
    {
        return 'string';
    }

    public function criteria()
    {
        return $this->belongsTo(StandardCriteria::class, 'standard_criteria_id');
    }

    public function subIndicators()
    {
        return $this->hasMany(SubIndicator::class, 'id');
    }

    public function reviewDocs()
    {
        return $this->hasMany(ReviewDocs::class, 'id');
    }

    public function auditPlanCriteria()
    {
        return $this->hasMany(AuditPlanCriteria::class, 'standard_criteria_id', 'standard_criteria_id');
    }
}
