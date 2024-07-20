<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardStatement extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'name',
        'standard_criteria_id',
    ];

    public function getKeyType()
    {
        return 'string';
    }

    public function criteria()
    {
        return $this->belongsTo(StandardCriteria::class, 'standard_criteria_id');
    }

    public function indicators()
    {
        return $this->hasMany(Indicator::class, 'standard_statement_id');
    }

    public function reviewDocs()
    {
        return $this->hasMany(ReviewDocs::class, 'standard_statement_id');
    }
}
