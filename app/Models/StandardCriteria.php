<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StandardCriteria extends Model
{
    use HasFactory;

    // Define $timestamps as true since you have timestamps in your table
    public $timestamps = true;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'standard_categories_id',
        'title',
        'audit_status_id'
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically generate a UUID for the 'id' field
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(StandardCategory::class, 'standard_categories_id');
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }

    public function getKeyType()
    {
        return 'string';
    }
}
