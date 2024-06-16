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
        'indicator_id',
        'lecture_id',
        'standard_criterias_id',
        'standard_id',
        'remark',
        'doc_path',
        'required',
        'topic',
        'class_type',
        'total_students'
    ];

    public function lecture()
    {
        return $this->belongsTo(User::class, 'lecture_id');
    }

    // Contoh relasi ke model AuditPlanStatus
    public function auditstatus()
    {
        return $this->belongsTo(AuditStatus::class, 'audit_status_id');
    }
    public function category()
    {
        return $this->belongsTo(StandardCategory::class, 'standard_categories_id');
    }
}
