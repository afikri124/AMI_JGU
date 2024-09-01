<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditPlan extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'audit_plans';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'auditee_id',
        'date_start',
        'date_end',
        'audit_status_id',
        'location_id',
        'department_id',
        'auditor_id',
        'periode',
        'type_audit',
        'remark_standard_lpm',
        'head_major',
        'upm_major',
    ];

    // Relasi ke model lain (opsional, jika diperlukan)
    public function auditee()
    {
        return $this->belongsTo(User::class, 'auditee_id');
    }

    public function auditStatus()
    {
        return $this->belongsTo(AuditStatus::class, 'audit_status_id');
    }

    public function departments()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function locations()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function auditorId()
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }

    public function auditor()
    {
        return $this->hasMany(AuditPlanAuditor::class, 'audit_plan_id');
    }

    public function observations()
    {
        return $this->hasMany(Observation::class, 'audit_plan_id');
    }

    public function category()
    {
        return $this->belongsTo(AuditPlanCategory::class, 'standard_category_id');
    }

    public function criteria()
    {
        return $this->belongsTo(AuditPlanCriteria::class, 'standard_criteria_id');
    }

    public function indicator()
    {
        return $this->hasMany(Indicator::class, 'indicator_id');
    }

    public function review_document()
    {
        return $this->hasMany(ReviewDocs::class, 'review_document_id');
    }

    public function obs_c()
    {
        return $this->hasMany(ObservationChecklist::class, 'observation_id');
    }

    public function department()
    {
    return $this->hasOneThrough(Department::class, User::class, 'id', 'id', 'auditee_id', 'department_id');
    }


}
