<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditPlanAuditor extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id', 'audit_plan_id', 'auditor_id'
    ];

    public function auditPlan(){
        return $this->belongsTo(AuditPlan::class, 'audit_plan_id');
    }

    public function auditor(){
        return $this->belongsTo(User::class, 'auditor_id');
    }

    public function criteriaId()
    {
        return $this->belongsTo(StandardCategory::class, 'standard_category_id');
    }

    public function categoryId()
    {
        return $this->belongsTo(StandardCriteria::class, 'standard_criteria_id');
    }

    public function criteria()
    {
        return $this->hasMany(AuditPlanCriteria::class, 'audit_plan_auditor_id');
    }

    public function category()
    {
        return $this->hasMany(AuditPlanCategory::class, 'audit_plan_auditor_id');
    }

}
