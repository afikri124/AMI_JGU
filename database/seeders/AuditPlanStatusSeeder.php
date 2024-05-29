<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditPlanStatus;

class AuditPlanStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        $data = [
            [
                'user_id' => 'Muhammad Rofiq',
                'date' => '2024-5-14',
                'location_id' => 'Class 13',
                'file_path' => '/Revisi.jpg',
                'description' => 'Revisi ke 2',

            ],
            // Tambahkan data contoh lain sesuai kebutuhan
        ];

        // Masukkan data contoh ke tabel audit_plan
        foreach ($data as $audit_status) {
            AuditPlanStatus::create($audit_status);
        }
}
    }
