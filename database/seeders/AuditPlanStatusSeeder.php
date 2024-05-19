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
    public function run() {
        // Buat beberapa data contoh
            AuditPlanStatus::create(
            [
                'name' => 'Pending',
                'title' => 'Pending Approval',
                'remark_by_lpm' => null,
                'remark_by_approver' => null,
            ]);
            AuditPlanStatus::create(
            [
                'name' => 'Approved',
                'title' => 'Approved',
                'remark_by_lpm' => 'Approved by LPM',
                'remark_by_approver' => 'Approved by Approver',
            ]);
            AuditPlanStatus::create(
            [
                'name' => 'Rejected',
                'title' => 'Rejected',
                'remark_by_lpm' => 'Rejected by LPM',
                'remark_by_approver' => 'Rejected by Approver',
            ]);
        }
    }
