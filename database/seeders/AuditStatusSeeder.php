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
<<<<<<< HEAD
            ["id" => "1", "title" => "Scheduled", "color" => "success"],
            ["id" => "2", "title" => "Reschedule", "color" => "success"],
            ["id" => "3", "title" => "Process", "color" => "success"],
            ["id" => "4", "title" => "Approved by auditor", "color" => "success"],
            ["id" => "5", "title" => "Revised", "color" => "success"],
            ["id" => "6", "title" => "Approved by LPM", "color" => "success"],
            ["id" => "7", "title" => "Request note by LPM", "color" => "success"],
            ["id" => "8", "title" => "Approved by Approver", "color" => "success"],
            ["id" => "9", "title" => "Request note by Approver", "color" => "success"],
=======
            ["id" => "1",
             "title" => "Scheduled", 
             "color" => "#000000"],

            ["id" => "2", 
            "title" => "Reschedule", 
            "color" => "#3572EF"],

            ["id" => "3", 
            "title" => "Process", 
            "color" => "#3572EF"],

            ["id" => "4", 
            "title" => "Approved by auditor", 
            "color" => "#3572EF"],

            ["id" => "5", 
            "title" => "Revised", 
            "color" => "#3572EF"],

            ["id" => "6", 
            "title" => "Approved by LPM", 
            "color" => "#3572EF"],

            ["id" => "7", 
            "title" => "Request note by LPM", 
            "color" => "#3572EF"],

            ["id" => "8", 
            "title" => "Approved by Approver", 
            "color" => "#3572EF"],

            ["id" => "9", 
            "title" => "Request note by Approver", 
            "color" => "#3572EF"],
>>>>>>> b85f107e9155fb86d9bde4550b331e6977679fc3
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
