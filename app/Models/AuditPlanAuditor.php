<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditPlanAuditor extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id', 'audit_plan_id', 'auditor_id'
    ];

    public function auditPlan(){
        return $this->belongsTo(AuditPlan::class, 'audit_plan_id');
    }

    public function auditor(){
        return $this->belongsTo(User::class, 'auditor_id');
    }
}
