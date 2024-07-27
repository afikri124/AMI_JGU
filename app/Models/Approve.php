<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approve extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id',
        'observation_id',
        'audit_status_id',
        'remark_by_lpm',
        'remark_by_approver',
    ];

    public function approve()
    {
        return $this->belongsTo(Observation::class, 'observation_id');
    }
}
