<?php

namespace Database\Seeders;

use App\Models\Indicator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File as FacadesFile;


class IndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ["id" => "1", "name" => "Ketersediaan pedoman perumusan capaian pembelajaran", "standard_criteria_id" => "1"],
            ["id" => "2", "name" => "Ketersediaan profil lulusan", "standard_criteria_id" => "1"],
            ["id" => "3", "name" => "Ketersediaan rumusan capaian pembelajaran dan bukti pelaksanaan capaian pembelajaran lulusan", "standard_criteria_id" => "1"],
            ["id" => "4", "name" => "Kesesuaian rumusan capaian pembelajaran jurusan dengan visi, misi, dan tujuan Universitas Global Jakarta dan visi-dan misi, serta tujuan Jurusan.", "standard_criteria_id" => "1"],
            ["id" => "5", "name" => "Ketesediaan SK Dekan tentang tim perumus capaian pembelajaran lulusan.", "standard_criteria_id" => "1"],
            ["id" => "6", "name" => "Ketersediaan SK Rektor tentang capaian pembelajaran lulusan.", "standard_criteria_id" => "1"],
            ["id" => "7", "name" => "50% lulusan memiliki nilai IPK 3,00.", "standard_criteria_id" => "1"],
            ["id" => "8", "name" => "75% masa tunggu lulusan untuk mendapatkan pekerjaan adalah ≤ 6 bulan.", "standard_criteria_id" => "1"],
            ["id" => "9", "name" => "75% lulusan bekerja sesuai bidang studi.", "standard_criteria_id" => "1"],
            ["id" => "10", "name" => "Tersedianya laporan kinerja penelitian", "standard_criteria_id" => "9"],
            ["id" => "11", "name" => "Tersedianya buku pedoman penelitian", "standard_criteria_id" => "9"],
            ["id" => "12", "name" => "Tersedianya pedoman penulisan laporan akhir penelitian", "standard_criteria_id"=> "9"],
            ["id" => "13", "name" => "Tersedianya pedoman penulisan tugas akhir", "standard_criteria_id" => "9"]
        ];

        foreach ($data as $x) {
            if(!Indicator::where('id', $x['id'])->first()){
                $m = new Indicator();
                $m->id = $x['id'];
                $m->name = $x['name'];
                $m->standard_criteria_id = $x['standard_criteria_id'];
                $m->save();
            }
        }
    }
}
