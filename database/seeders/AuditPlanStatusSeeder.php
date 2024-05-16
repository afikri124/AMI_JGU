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
    public function run()
    {
        // Buat beberapa data contoh
        $auditPlanStatuses = [
            [
                'name' => 'Pending',
                'title' => 'Pending Approval',
                'remark_by_lpm' => null,
                'remark_by_approver' => null,
            ],
            [
                'name' => 'Approved',
                'title' => 'Approved',
                'remark_by_lpm' => 'Approved by LPM',
                'remark_by_approver' => 'Approved by Approver',
            ],
            [
                'name' => 'Rejected',
                'title' => 'Rejected',
                'remark_by_lpm' => 'Rejected by LPM',
                'remark_by_approver' => 'Rejected by Approver',
            ],
        ];

        // Masukkan data ke dalam tabel
        foreach ($auditPlanStatuses as $status) {
            AuditPlanStatus::create($status);
        }
    }
}
