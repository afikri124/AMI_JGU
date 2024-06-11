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
        'auditor_id',
        'location_id',
        'department_id',
        'standar_id',
        'attendance',
        'remark',
        'doc_path',
        'subject_course',
        'topic',
        'class_type',
        'total_students'
    ];
}
