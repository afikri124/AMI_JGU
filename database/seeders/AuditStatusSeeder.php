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
            "title" => "Audit Finished",
            "color" => "success"],

            ["id" => "7",
            "title" => "Approved Report by LPM",
            "color" => "secondary"],

            ["id" => "8",
            "title" => "Request Note\nby LPM",
            "color" => "primary"],

            ["id" => "9",
<<<<<<< HEAD
            "title" => "Approved by Approver",
            "color" => "dark"],
=======
            "title" => "RTM Process",
            "color" => "secondary"],
>>>>>>> af1ea214da049afa7d4deabc6b44cd8d19b0b683

            ["id" => "10",
            "title" => "Uploaded RTM",
            "color" => "dark"],

            ["id" => "11",
            "title" => "Uploaded",
            "color" => "success"],

            ["id" => "12",
            "title" => "Reuploaded",
<<<<<<< HEAD
            "color" => "blue"],

            ["id" => "13",
            "title" => "Standard\nUpdated",
            "color" => "blue"],
        ];
=======
            "color" => "primary"],

            ["id" => "13",
            "title" => "Standard\nUpdated",
            "color" => "secondary"],
>>>>>>> af1ea214da049afa7d4deabc6b44cd8d19b0b683

            ["id" => "14",
            "title" => "RTM Finished",
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
