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
            ["id" => "1", "name" => "Ketersediaan pedoman perumusan capaian pembelajaran"],
            ["id" => "2", "name" => "Ketersediaan profil lulusan"],
            ["id" => "3", "name" => "Ketersediaan rumusan capaian pembelajaran dan bukti pelaksanaan capaian pembelajaran lulusan"],
            ["id" => "4", "name" => "Kesesuaian rumusan capaian pembelajaran jurusan dengan visi, misi, dan tujuan Universitas Global Jakarta dan visi-dan misi, serta tujuan Jurusan."],
            ["id" => "5", "name" => "Ketesediaan SK Dekan tentang tim perumus capaian pembelajaran lulusan."],
            ["id" => "6", "name" => "Ketersediaan SK Rektor tentang capaian pembelajaran lulusan."],
            ["id" => "7", "name" => "50% lulusan memiliki nilai IPK 3,00."],
            ["id" => "8", "name" => "75% masa tunggu lulusan untuk mendapatkan pekerjaan adalah ≤ 6 bulan."],
            ["id" => "9", "name" => "75% lulusan bekerja sesuai bidang studi."],
        ];

        foreach ($data as $x) {
            if(!Indicator::where('id', $x['id'])->first()){
                $m = new Indicator();
                $m->id = $x['id'];
                $m->name = $x['name'];
                $m->save();
            }
        }
    }
}
