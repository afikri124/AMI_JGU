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
            $data = [
                [
                    'date' => '2024-5-14',
                    'audit_plan_status_id' => 1,
                    'location_id' => 3,
                    'lecture_id' => 4,
                    'auditor_id' => 2,
                    'department_id' => 5,
                ],
                // Tambahkan data contoh lain sesuai kebutuhan
            ];

            // Masukkan data contoh ke tabel audit_plan
            foreach ($data as $auditPlan) {
                AuditPlan::create($auditPlan);
            }
    }
}
