<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardCriteria extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id', 
        'standard_id',
        'sub_indicator_id',
        'audit_status_id',
        'standard_category_id',
        'remark',
        'required',
        'indicator_id'
    ];

    public function category()
    {
        return $this->belongsTo(StandardCategory::class, 'standard_category_id');
    }

    public function sub_indicator()
    {
        return $this->belongsTo(SubIndicator::class, 'sub_indicator_id');
    }

    public function audit_status()
    {
        return $this->belongsTo(AuditStatus::class, 'audit_status_id');
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }

    public function standard()
    {
        return $this->belongsTo(Standard::class, 'standard_id');
    }
}
