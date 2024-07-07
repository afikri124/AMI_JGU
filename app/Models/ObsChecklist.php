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
        'ks',
        'obs',
        'kts_minor',
        'kts_mayor',
        'description_remark',
        'success_remark',
        'failed_remark',
        'recommend_remark'
    ];

}
