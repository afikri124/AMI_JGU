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
        'doc_path',
        'link',
        'remark_docs',
        'remark_description',
        'obs_checklist_option',
        'remark_success_failed',
        'remark_recommend',
        'remark_upgrade_repair',
        'person_in_charge',
        'plan_completed',
        'remark_path_auditee',
    ];

    public function obs_c()
    {
        return $this->belongsTo(Observation::class, 'observation_id');
    }

    public function standardCriteria()
    {
        return $this->belongsTo(StandardCriteria::class, 'standard_criteria_id');
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }
}
