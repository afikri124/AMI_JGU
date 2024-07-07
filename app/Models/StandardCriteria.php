<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StandardCriteria extends Model
{
    use HasFactory;

    // Define $timestamps as true since you have timestamps in your table
    public $timestamps = true;
    public $incrementing = false;
    protected $fillable = [
        'standard_categories_id',
        'title',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(StandardCategory::class, 'standard_categories_id');
    }

    public function status()
    {
        return $this->belongsTo(AuditStatus::class, 'audit_status_id');
    }

    public function auditPlan()
    {
        return $this->hasMany(AuditPlan::class, 'id');
    }

    public function indicators()
    {
        return $this->hasMany(Indicator::class, 'standard_criterias_id');
    }

    public function reviewDocs()
    {
        return $this->hasMany(ReviewDocs::class, 'standard_criterias_id');
    }
}
