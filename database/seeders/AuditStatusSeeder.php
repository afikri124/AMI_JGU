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
            ["id" => "1",
            "title" => "Scheduled",
            "color" => "success"],

            ["id" => "2",
            "title" => "Reschedule",
            "color" => "success"],

            ["id" => "3",
            "title" => "Process",
            "color" => "success"],

            ["id" => "4",
            "title" => "Approved by auditor",
            "color" => "success"],

            ["id" => "5",
            "title" => "Revised",
            "color" => "success"],

            ["id" => "6",
            "title" => "Approved by LPM",
            "color" => "success"],

            ["id" => "7",
            "title" => "Request note by LPM",
            "color" => "success"],

            ["id" => "8",
            "title" => "Approved by Approver",
            "color" => "success"],

            ["id" => "9",
            "title" => "Request note by Approver",
            "color" => "success"],
        ];


        foreach ($data as $x) {
            if(!AuditStatus::where('id', $x['id'])->first()){
                $m = new AuditStatus();
                $m->id = $x['id'];
                $m->title = $x['title'];
                $m->color = $x['color'];
                $m->save();
            }
        }
    }
}
