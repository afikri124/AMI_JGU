<?php

namespace Database\Seeders;

use App\Models\StandardCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File as FacadesFile;


class StandardCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ["id" => "1", "title" => "Wajib", "description" => "Standar Pendidikan", "status" => true],
            ["id" => "2", "title" => "Wajib", "description" => "Standar Penelitian", "status" => true],
            ["id" => "3", "title" => "Wajib", "description" => "Standar Pengabdian Masyarakat", "status" => true],
            ["id" => "4", "title" => "Wajib", "description" => "Standar Tambahan", "status" => true]
        ];

        foreach ($data as $x) {
            if(!StandardCategory::where('id', $x['id'])->first()){
                $m = new StandardCategory();
                $m->id = $x['id'];
                $m->title = $x['title'];
                $m->description = $x['description'];
                $m->status = $x['status'];
                $m->save();
            }
        }
    }
}
