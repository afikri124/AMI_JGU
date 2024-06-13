<?php

namespace Database\Seeders;

use App\Models\Indicator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ["id" => "1", "name" => "Ketersediaan pedoman perumusan capaian pembelajaran
                                    Ketersediaan profil lulusan
                                    ketersediaan rumusan capaian pembelajaran dan bukti pelaksanaan capaian pembelajaran lulusan
                                    kesesuaian rumusan capaian pembelajaran jurusan dengan visi, misi, dan tujuan Universitas Global Jakarta dan visi-dan misi, serta tujuan Jurusan.
                                    ketesediaan SK Dekan tentang tim perumus capaian pembelajaran lulusan.
                                    ketersediaan SK Rektor tentang capaian pembelajaran lulusan.
                                    50% lulusan memiliki nilai IPK 3,00.
                                    75% masa tunggu lulusan untuk mendapatkan pekerjaan adalah ≤ 6 bulan.
                                    75% lulusan bekerja sesuai bidang studi."]
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
