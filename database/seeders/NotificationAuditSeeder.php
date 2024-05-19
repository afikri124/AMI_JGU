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
            NotificationAudit::create(
            [
                'date' => '2024-05-19',
                'program' => 'Pembiayaan Mahasiswa',
                'auditor' => 'Arisa',
            ]);
    }
}
