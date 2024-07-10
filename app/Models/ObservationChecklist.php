<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObsChecklist extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'observation_id',
        'remark_description',
        'remark_plan',
        'obs_checklist_option',
        'remark_success_failed',
        'remark_recommend',
        'remark_upgrade_repair',
        'person_in_charge',
        'plan_complated',
    ];

}
