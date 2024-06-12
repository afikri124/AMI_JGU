<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id', 'title', 'description', 'is_required','status_id'
    ];

    public function criterias()
    {
        return $this->hasMany(StandardCriteria::class, 'id');
    }

    public function status()
    {
        return $this->belongsTo(AuditStatus::class, 'status_id');
    }
}
