<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditPlan;

class AuditPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
        // Data contoh untuk tabel audit_plan
        public function run(): void {
        AuditPlan::create([
            'date' => '2024-05-19',
            'audit_plan_status_id' => 2,
            'auditee_id' => 3,
            'location_id' => 4,
            'auditor_id' => 5,
            'departement_id' => 6,
        ]);
    }
}
