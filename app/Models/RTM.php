<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RTM extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id',
        'observation_id',
        'indicator_id',
        'doc_path_rtm',
        'plan_complated_end',
        'status'
    ];

    public function obs_c()
    {
        return $this->belongsTo(Observation::class, 'observation_id');
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }
}
