<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditPlan extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'audit_plan';

    // Menentukan kolom-kolom yang dapat diisi
    protected $fillable = [
        'date',
        'audit_plan_status_id',
        'location_id',
        'lecture_id',
        'auditor_id',
        'department_id'
    ];

    // Relasi ke model lain (opsional, jika diperlukan)

    // Contoh relasi ke model AuditPlanStatus
    public function auditPlanStatus()
    {
        return $this->belongsTo(AuditPlanStatus::class, 'audit_plan_status_id');
    }



    public function lecture()
    {
        return $this->belongsTo(User::class, 'lecture_id');
    }

    public function auditor()
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }

    // // Contoh relasi ke model Auditee
    // public function auditee()
    // {
    //     return $this->belongsTo(Auditee::class, 'auditee_id');
    // }

    // // Contoh relasi ke model Location
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    // // Contoh relasi ke model Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
