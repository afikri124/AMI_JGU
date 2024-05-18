<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditPlan;
use Carbon\Carbon;

class AuditPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data contoh untuk tabel audit_plan
        $auditPlans = [
            [
                'date' => Carbon::create(2024, 5, 14),
                'audit_plan_status_id' => 1,
                'auditee_id' => 2,
                'location_id' => 3,
                'auditor_id' => 4,
                'departement_id' => 5,
            ],
            [
                'date' => Carbon::create(2024, 6, 15),
                'audit_plan_status_id' => 2,
                'auditee_id' => 3,
                'location_id' => 4,
                'auditor_id' => 5,
                'departement_id' => 6,
            ],
            // Tambahkan data contoh lain sesuai kebutuhan
        ];

        // Masukkan data contoh ke tabel audit_plan
        foreach ($auditPlans as $auditPlan) {
            AuditPlan::create($auditPlan);
        }
    }
}
