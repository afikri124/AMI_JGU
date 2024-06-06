<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditPlan extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'audit_plans';

    // Menentukan kolom-kolom yang dapat diisi
    protected $fillable = [
        'lecture_id',
        'date_start',
        'date_end',
        'audit_status_id',
        'location_id',
        'department_id',
        'auditor_id',
        'doc_path',
        'link',
        ];

    // Relasi ke model lain (opsional, jika diperlukan)

    public function lecture()
    {
        return $this->belongsTo(User::class, 'lecture_id');
    }

    // Contoh relasi ke model AuditPlanStatus
    public function auditstatus()
    {
        return $this->belongsTo(AuditStatus::class, 'audit_status_id');
    }

    // // Contoh relasi ke model Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function auditor()
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

}
