<?php

namespace Database\Seeders;

use App\Models\NotificationAudit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationAuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() {
        // Buat beberapa data contoh
        $data = [
            [
                'date' => '2024-5-14',
                'program' => 'Pembiayaan Mahasisa JGU',
                'auditor' => 'Aria'
            ],
            // Tambahkan data contoh lain sesuai kebutuhan
        ];

        // Masukkan data contoh ke tabel audit_plan
        foreach ($data as $notificationaudit) {
            NotificationAudit::create($notificationaudit);
        }
    }
}
