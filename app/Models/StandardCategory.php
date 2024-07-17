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

    public function category()
    {
        return $this->hasMany(StandardCategory::class);
    }

    public function criterias()
    {
        return $this->hasMany(StandardCriteria::class, 'id');
    }

    public function auditPlan()
    {
        return $this->hasMany(AuditPlan::class, 'id');
    }

    public function observations()
    {
        return $this->hasMany(Observation::class, 'id');
    }
}
