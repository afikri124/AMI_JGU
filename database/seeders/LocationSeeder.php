<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;
use Illuminate\Support\Facades\File;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
                [
                 "id"=> "1",
                 "title"=> "Asphalt Laboratory"
                ],
                [
                 "id"=> "2",
                 "title"=> "Auditorium"
                ],
                [
                 "id"=> "3",
                 "title"=> "Basic & Machine Achievements Laboratory"
                ],
                [
                 "id"=> "4",
                 "title"=> "Centrifugal Pump Laboratory"
                ],
                [
                 "id"=> "5",
                 "title"=> "Class - 01"
                ],
                [
                 "id"=> "6",
                 "title"=> "Class - 02"
                ],
                [
                 "id"=> "7",
                 "title"=> "Class - 03"
                ],
                [
                 "id"=> "8",
                 "title"=> "Class - 04"
                ],
                [
                 "id"=> "9",
                 "title"=> "Class - 05"
                ],
                [
                 "id"=> "10",
                 "title"=> "Class - 06"
                ],
                [
                 "id"=> "11",
                 "title"=> "Class - 07"
                ],
                [
                 "id"=> "12",
                 "title"=> "Class - 08"
                ],
                [
                 "id"=> "13",
                 "title"=> "Class - 09"
                ],
                [
                 "id"=> "14",
                 "title"=> "Class - 10"
                ],
                [
                 "id"=> "15",
                 "title"=> "Class - 11"
                ],
                [
                 "id"=> "16",
                 "title"=> "Class - 12"
                ],
                [
                 "id"=> "17",
                 "title"=> "Class - 13"
                ],
                [
                 "id"=> "18",
                 "title"=> "Class - 14"
                ],
                [
                 "id"=> "19",
                 "title"=> "Class - 15"
                ],
                [
                 "id"=> "20",
                 "title"=> "Class - 16"
                ],
                [
                 "id"=> "21",
                 "title"=> "Class - 17"
                ],
                [
                 "id"=> "22",
                 "title"=> "Class - 18"
                ],
                [
                 "id"=> "23",
                 "title"=> "Class - 19"
                ],
                [
                 "id"=> "24",
                 "title"=> "Class - 20"
                ],
                [
                 "id"=> "25",
                 "title"=> "Class - 21"
                ],
                [
                 "id"=> "26",
                 "title"=> "Class - 22"
                ],
                [
                 "id"=> "27",
                 "title"=> "Class - 23"
                ],
                [
                 "id"=> "28",
                 "title"=> "Class - 23"
                ],
                [
                 "id"=> "29",
                 "title"=> "Class - 24"
                ],
                [
                 "id"=> "30",
                 "title"=> "Class - 25"
                ],
                [
                 "id"=> "31",
                 "title"=> "COE Laboratory"
                ],
                [
                 "id"=> "32",
                 "title"=> "Computer Laboratory-1"
                ],
                [
                 "id"=> "33",
                 "title"=> "Computer Laboratory-2"
                ],
                [
                 "id"=> "34",
                 "title"=> "Concrete Laboratory"
                ],
                [
                 "id"=> "35",
                 "title"=> "Control System & Instrumentation Laboratory"
                ],
                [
                 "id"=> "36",
                 "title"=> "Electric Power Engineer Laboratory"
                ],
                [
                 "id"=> "37",
                 "title"=> "Electronic & Robotic Laboratory"
                ],
                [
                 "id"=> "38",
                 "title"=> "Fluid Mechanics Laboratory"
                ],
                [
                 "id"=> "39",
                 "title"=> "Language Laboratory"
                ],
                [
                 "id"=> "40",
                 "title"=> "Lecture Theatre-1"
                ],
                [
                 "id"=> "41",
                 "title"=> "Lecture Theatre-2"
                ],
                [
                 "id"=> "42",
                 "title"=> "Lecture Theatre-3"
                ],
                [
                 "id"=> "43",
                 "title"=> "Lecture Theatre-4"
                ],
                [
                 "id"=> "44",
                 "title"=> "Lecture Theatre-5"
                ],
                [
                 "id"=> "45",
                 "title"=> "Lecture Theatre-6"
                ],
                [
                 "id"=> "46",
                 "title"=> "Library"
                ],
                [
                 "id"=> "47",
                 "title"=> "Metal Science Laboratory"
                ],
                [
                 "id"=> "48",
                 "title"=> "Microbiology Laboratory"
                ],
                [
                 "id"=> "49",
                 "title"=> "Multimedia Studio "
                ],
                [
                 "id"=> "50",
                 "title"=> "Pharmaceutical Chemistry Laboratory"
                ],
                [
                 "id"=> "51",
                 "title"=> "Pharmaceutical Laboratory"
                ],
                [
                 "id"=> "52",
                 "title"=> "Pharmacognosy Laboratory"
                ],
                [
                 "id"=> "53",
                 "title"=> "Pharmacology Laboratory"
                ],
                [
                 "id"=> "54",
                 "title"=> "Physics\/Mechanics Laboratory"
                ],
                [
                 "id"=> "55",
                 "title"=> "Process & Production System Laboratory"
                ],
                [
                 "id"=> "56",
                 "title"=> "Simulation\/Optimation Laboratory"
                ],
                [
                 "id"=> "57",
                 "title"=> "Soil Mechanics Laboratory"
                ],
                [
                 "id"=> "58",
                 "title"=> "Solid Pharmaceuticals Laboratory"
                ],
                [
                 "id"=> "59",
                 "title"=> "Sterile Laboratory"
                ],
                [
                 "id"=> "60",
                 "title"=> "Telecomunication & Microwave Laboratory"
                ],
                [
                 "id"=> "61",
                 "title"=> "Work System Design & Ergonomics Laboratory"
                ],
                [
                "id"=> "62",
                "title"=> "Faculty Room"
                ],
                [
                "id"=> "63",
                "title"=> "Lecturer Room"
                ]
        ];

        foreach ($data as $x) {
            if(!Location::where('id', $x['id'])->first()){
                $m = new Location();
                $m->id = $x['id'];
                $m->title = $x['title'];
                $m->save();
            }
        }
}
}
