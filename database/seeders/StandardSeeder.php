<?php

namespace Database\Seeders;

use App\Models\Standard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StandardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ["id" => "1", "name" => "Standar Kompetensi Kelulusan"],
            ["id" => "2", "name" => "Standar Dosen dan Tenaga Kependidikan"],
            ["id" => "3", "name" => "Standar Isi Pembelajaran"],
            ["id" => "4", "name" => "Standar Proses Pembelajaran"],
            ["id" => "5", "name" => "Standar Pengelolaan Pembelajaran"],
            ["id" => "6", "name" => "Standar Penilaian Pembelajaran"],
            ["id" => "7", "name" => "Standar Sarana dan Pra Sarana Pembelajaran"],
            ["id" => "8", "name" => "Standar Pembiayaan Pembelajaran"],
        ];

        foreach ($data as $x) {
            if(!Standard::where('id', $x['id'])->first()){
                $m = new Standard();
                $m->id = $x['id'];
                $m->name = $x['name'];
                $m->save();
            }
        }
    }
}
