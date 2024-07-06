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
        'audit_status_id',
        'auditor_id',
        'location_id',
        'department_id',
        'lecture_id',
        'standard_criterias_id',
        'standard_categories_id',
        'indicator_id',
        'sub_indicator_id',
        'remark_ass',
        'doc_path',
        'total_students',
        'link',
        'title_ass'
    ];

    public function auditPlan()
    {
        return $this->belongsTo(AuditPlan::class, 'audit_plan_id');
    }

    public function lecture()
    {
        return $this->belongsTo(User::class, 'lecture_id');
    }

    // Contoh relasi ke model AuditPlanStatus
    public function auditstatus()
    {
        return $this->belongsTo(AuditStatus::class, 'audit_status_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
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
}
