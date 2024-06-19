<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id', 'title', 'description', 'is_required','audit_status_id'
    ];

    public function category()
    {
        return $this->hasMany(StandardCategory::class);
    }

    public function criterias()
    {
        return $this->hasMany(StandardCriteria::class, 'id');
    }

    public function auditplan()
    {
        return $this->hasMany(AuditPlan::class, 'id');
    }
    
    public function observations()
    {
        return $this->hasMany(Observation::class, 'id');
    }
    public function status()
    {
        return $this->belongsTo(AuditStatus::class, 'audit_status_id');
    }
}
