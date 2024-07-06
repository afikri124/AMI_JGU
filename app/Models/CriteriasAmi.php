<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriasAmi extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id', 'audit_plan_id', 'standard_categories_id'
    ];

    public function auditPlan(){
        return $this->belongsTo(AuditPlan::class, 'audit_plan_id');
    }
}
