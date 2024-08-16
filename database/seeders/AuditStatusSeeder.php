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
            "color" => "info"],

            ["id" => "2",
            "title" => "Reschedule",
            "color" => "primary"],

            ["id" => "3",
            "title" => "Process",
            "color" => "warning"],

            ["id" => "4",
            "title" => "Approved Standard by LPM",
            "color" => "success"],

            ["id" => "5",
            "title" => "Revised Standard by LPM",
            "color" => "success"],

            ["id" => "6",
            "title" => "Approved\nby Auditor",
            "color" => "success"],

            ["id" => "7",
            "title" => "Approved Audit Report by LPM",
            "color" => "success"],

            ["id" => "8",
            "title" => "Request Note\nby LPM",
            "color" => "primary"],

            ["id" => "9",
            "title" => "Approved by Approver",
            "color" => "dark"],

            ["id" => "10",
            'title' => "Request Note\nby Approver",
            "color" => "primary"],

            ["id" => "11",
            "title" => "Uploaded",
            "color" => "success"],

            ["id" => "12",
            "title" => "Reuploaded",
            "color" => "blue"],

            ["id" => "13",
            "title" => "Standard\nUpdated",
            "color" => "blue"],
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
