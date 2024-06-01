<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditDoc extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'audit_docs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'audit_plan_id',
        'doc_path',
        'date',
        'audit_doc_list_name_id',
        'audit_doc_status_id',
        'remark_by_auditor',
        'remark_by_lecture',
        'link'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function auditPlan()
    {
        return $this->belongsTo(AuditPlan::class, 'audit_plan_id');
    }

    public function lecture()
    {
        return $this->belongsTo(User::class, 'lecture_id');
    }

    // public function auditDocListName()
    // {
    //     return $this->belongsTo(User::class, 'audit_doc_list_name_id');
    // }

    // public function auditDocStatus()
    // {
    //     return $this->belongsTo(User::class, 'audit_doc_status_id');
    // }
}
