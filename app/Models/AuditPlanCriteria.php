<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditPlanCriteria extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id', 'audit_plan_auditor_id', 'standard_criteria_id'
    ];

    public function auditor(){
        return $this->belongsTo(AuditPlanAuditor::class, 'audit_plan_auditor_id');
    }

    public function criteria()
    {
        return $this->belongsTo(StandardCriteria::class, 'standard_criteria_id');
    }

}
