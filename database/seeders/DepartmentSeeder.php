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
            ["id" => "1", "name" => "Bisnis Digital"],
            ["id" => "2", "name" => "Akuntansi"],
            ["id" => "3", "name" => "Managemen"],
            ["id" => "4", "name" => "Teknik Sipil"],
            ["id" => "5", "name" => "Teknik Mesin"],
            ["id" => "6", "name" => "Teknik Informatika"],
            ["id" => "7", "name" => "Teknik Elektro"],
            ["id" => "8", "name" => "Teknik Industri"],
            ["id" => "9", "name" => "Farmasi"],
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
