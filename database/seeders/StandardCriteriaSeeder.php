<?php

namespace Database\Seeders;

use App\Models\StandardCriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File as FacadesFile;


class StandardCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ["id" => "1", "title" => "Standar Kompetensi Lulusan"],
            ["id" => "2", "title" => "Standar Dosen & Tenaga Kependidikan"],
            ["id" => "3", "title" => "Standar Isi Pembelajaran"],
            ["id" => "4", "title" => "Standar Proses Pembelajaran"],
            ["id" => "5", "title" => "Standar Pengelolaan Pembelajaran"],
            ["id" => "6", "title" => "Standar Penilaian Pembelajaran"],
            ["id" => "7", "title" => "Standar Sarana Dan Prasarana Pembelajaran"],
            ["id" => "8", "title" => "Standar Pembiayaan Pembelajaran"],
        ];

        foreach ($data as $x) {
            if(!StandardCriteria::where('id', $x['id'])->first()){
                $m = new StandardCriteria();
                $m->id = $x['id'];
                $m->title = $x['title'];
                $m->save();
            }
        }
    }
}
