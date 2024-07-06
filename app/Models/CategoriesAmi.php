<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesAmi extends Model
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

    public function category(){
        return $this->belongsTo(StandardCategory::class, 'standard_categories_id');
    }
}
