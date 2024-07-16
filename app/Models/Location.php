<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id', 'title'
    ];

    public function auditplan()
    {
        return $this->hasMany(AuditPlan::class, 'id');
    }
}
