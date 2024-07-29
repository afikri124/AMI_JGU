<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardCategory extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id', 'title', 'description', 'is_required', 'status'
    ];

    public function criterias()
    {
        return $this->hasMany(StandardCriteria::class, 'standard_category_id');
    }

    public function auditPlan()
    {
        return $this->hasMany(AuditPlan::class, 'audit_plan_id');
    }

    public function observations()
    {
        return $this->hasMany(Observation::class, 'observation_id');
    }
}
