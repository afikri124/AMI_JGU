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
            "color" => "primary"],

            ["id" => "3",
            "title" => "Process",
            "color" => "warning"],

            ["id" => "4",
            "title" => "Approved by Auditor",
            "color" => "secondary"],

            ["id" => "5",
            "title" => "Revised by Auditor",
            "color" => "primary"],

            ["id" => "6",
            "title" => "Approved by LPM",
            "color" => "success"],

            ["id" => "7",
            "title" => "Request note by LPM",
            "color" => "primary"],

            ["id" => "8",
            "title" => "Approved by Approver",
            "color" => "dark"],

            ["id" => "9",
            "title" => "Request note by Approver",
            "color" => "primary"],

            ["id" => "10",
            "title" => "Uploaded",
            "color" => "dark"],

            ["id" => "11",
            "title" => "Reuploaded",
            "color" => "secondary"],

            ["id" => "12",
            "title" => "Success",
            "color" => "secondary"],
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
