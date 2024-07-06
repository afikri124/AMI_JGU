<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStandard extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id', 'auditor_id'
    ];

    public function auditor(){
        return $this->belongsTo(User::class, 'auditor_id');
    }

    public function user_standard(){
        return $this->hasMany(AuditPlan::class, 'id');
    }
}
