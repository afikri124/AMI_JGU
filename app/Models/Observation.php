<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'audit_plan_id',
        'auditor_id',
        'location_id',
    ];

    public function auditPlan()
    {
        return $this->belongsTo(AuditPlan::class, 'audit_plan_id');
    }

    public function auditor()
    {
        return $this->belongsTo(AuditPlanAuditor::class, 'auditor_id');
    }

    public function category()
    {
        return $this->belongsTo(StandardCategory::class, 'standard_categories_id');
    }

    public function criteria()
    {
        return $this->belongsTo(StandardCriteria::class, 'standard_criterias_id');
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }

    public function sub_indicator()
    {
        return $this->belongsTo(SubIndicator::class, 'sub_indicator_id');
    }

    public function review_docs()
    {
        return $this->belongsTo(ReviewDocs::class, 'review_docs_id');
    }
}
