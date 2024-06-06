<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $timestamps = false;

    // Nama tabel jika tidak mengikuti konvensi penamaan default
    protected $table = 'questions';

    // Kolom yang bisa diisi melalui mass assignment
    protected $fillable = [
        'id',
        'title',
        'weight',
    ];

    // Jika ada kolom yang tidak boleh diisi, gunakan guarded
    // protected $guarded = [];

    /**
     * Mendefinisikan relasi ke model lain (jika ada).
     */

    // Misalnya, jika Question berelasi dengan model Category
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_categories_id');
    }
}
