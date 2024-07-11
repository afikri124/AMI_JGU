<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditPlanCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id', 'audit_plan_auditor_id', 'standard_category_id'
    ];

    public function auditor(){
        return $this->belongsTo(AuditPlanAuditor::class, 'audit_plan_auditor_id');
    }

    public function category(){
        return $this->belongsTo(StandardCategory::class, 'standard_category_id');
    }
}
