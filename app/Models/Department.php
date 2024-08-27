<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id',
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    // Relationship with AuditPlan through Users (Auditee)
    public function auditPlans()
    {
        return $this->hasManyThrough(AuditPlan::class, User::class, 'department_id', 'auditee_id', 'id', 'id');
    }
}
