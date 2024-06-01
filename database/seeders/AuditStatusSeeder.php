<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditStatus;

class AuditStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            ["id" => "1", "title" => "Scheduled"],
            ["id" => "2", "title" => "Reschedule"],
            ["id" => "3", "title" => "Process"],
            ["id" => "4", "title" => "Approved by auditor"],
            ["id" => "5", "title" => "Revised"],
            ["id" => "6", "title" => "Approved by LPM"],
            ["id" => "7", "title" => "Request note by LPM"],
            ["id" => "8", "title" => "Approved by Approver"],
            ["id" => "9", "title" => "Request note by Approver"],
        ];

        foreach ($data as $x) {
            if(!AuditStatus::where('id', $x['id'])->first()){
                $m = new AuditStatus();
                $m->id = $x['id'];
                $m->title = $x['title'];
                $m->save();
            }
        }
    }
}