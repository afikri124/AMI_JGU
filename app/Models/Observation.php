<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id',
        'audit_plan_id',
        'audit_plan_auditor_id',
        'location_id',
        'remark_plan',
        'person_in_charge',
        'plan_complated',
        'date_prepared',
        'date_checked',
        'date_validated'
    ];

    public function auditPlan()
    {
        return $this->belongsTo(AuditPlan::class, 'audit_plan_id');
    }

    public function auditStatus()
    {
        return $this->belongsTo(AuditStatus::class, 'audit_status_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function auditor()
    {
        return $this->belongsTo(AuditPlanAuditor::class, 'audit_plan_auditor_id');
    }

    public function category()
    {
        return $this->belongsTo(StandardCategory::class, 'standard_categories_id');
    }

    public function criteria()
    {
        return $this->belongsTo(StandardCriteria::class, 'standard_criterias_id');
    }

    public function observations()
    {
        return $this->hasMany(Observation::class, 'audit_plan_auditor_id');
    }

    public function obs_c()
    {
        return $this->hasMany(ObservationChecklist::class, 'observation_id');
    }
}
