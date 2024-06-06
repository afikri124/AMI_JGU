<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditStandar extends Model
{
    use HasFactory;

    protected $table = 'standards';
    protected $fillable = [
        'id',
        'title',
        'description'
    ];
}
