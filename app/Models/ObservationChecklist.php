<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservationChecklist extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id',
        'observation_id',
        'indicator_id',
        'remark_description',
        'obs_checklist_option',
        'remark_success_failed',
        'remark_recommend',
        'remark_upgrade_repair',
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
