<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardAmi extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id', 'standard_categories_id'
    ];

    public function standard_ami(){
        return $this->hasMany(AuditPlan::class, 'id');
    }
}
