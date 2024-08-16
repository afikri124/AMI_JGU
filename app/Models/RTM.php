<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rtm extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id',
        'observation_id',
        'indicator_id',
        'doc_path_rtm',
        'status',
        'remark_rtm_auditee',
        'remark_rtm_auditor'
    ];

    public function rtm()
    {
        return $this->belongsTo(Observation::class, 'observation_id');
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }
}
