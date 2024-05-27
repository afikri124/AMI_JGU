<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationAudit extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'title',
        'file_path',
        'description',
        'date',
    ];
}
