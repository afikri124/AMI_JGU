<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StandardCriteria extends Model
{
    use HasFactory;

    // Define $timestamps as true since you have timestamps in your table
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'standard_category_id',
        'title',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(StandardCategory::class, 'standard_category_id');
    }

    public function status()
    {
        return $this->belongsTo(AuditStatus::class, 'audit_status_id');
    }
    public function statements()
    {
        return $this->hasMany(StandardStatement::class, 'standard_criteria_id');
    }

    public function indicators()
    {
        return $this->hasMany(Indicator::class, 'standard_criteria_id');
    }

    public function reviewDocs()
    {
        return $this->hasMany(ReviewDocs::class, 'standard_criteria_id');
    }
}
