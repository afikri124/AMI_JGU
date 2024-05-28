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
    public function run(): void
    {
        Department::truncate();
        $json = FacadesFile::get("database/data/department.json");
        $loc = json_decode($json);

        foreach ($loc as $key => $value) {
            Department::create([
                "id" => $value->id,
                "title" => $value->title
            ]);
    }
}
}
