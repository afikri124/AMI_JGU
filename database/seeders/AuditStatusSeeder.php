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
            "color" => "dark"],

            ["id" => "3",
            "title" => "Process",
            "color" => "warning"],

            ["id" => "4",
            "title" => "Approved by auditor",
            "color" => "secondary"],

            ["id" => "5",
            "title" => "Revised",
            "color" => "primary"],

            ["id" => "6",
            "title" => "Approved by LPM",
            "color" => "warning"],

            ["id" => "7",
            "title" => "Request note by LPM",
            "color" => "warning"],

            ["id" => "8",
            "title" => "Approved by Approver",
            "color" => "warning"],

            ["id" => "9",
            "title" => "Request note by Approver",
            "color" => "secondary"],

            ["id" => "10",
            "title" => "ON",
            "color" => "success"],

            ["id" => "11",
            "title" => "OFF",
            "color" => "primary"],
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
