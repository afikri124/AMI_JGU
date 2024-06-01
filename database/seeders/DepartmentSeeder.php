<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File as FacadesFile;


class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ["id" => "1", "name" => "Digital Business"],
            ["id" => "2", "name" => "Accounting"],
            ["id" => "3", "name" => "Management"],
            ["id" => "4", "name" => "Civil Engineering"],
            ["id" => "5", "name" => "Mechanical Engineering"],
            ["id" => "6", "name" => "Informatics Engineering"],
            ["id" => "7", "name" => "Electrical Engineering"],
            ["id" => "8", "name" => "Industrial Engineering"],
            ["id" => "9", "name" => "Pharmacy"],
        ];

        foreach ($data as $x) {
            if(!Department::where('id', $x['id'])->first()){
                $m = new Department();
                $m->id = $x['id'];
                $m->name = $x['name'];
                $m->save();
            }
        }
    }
}
