<?php

namespace Database\Seeders;

use App\Models\SubIndicator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubIndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ["id" => "1", "name" => "1. Terdapat pedoman perumusan capaian pembelajaran
                                    2. Rancangan kurikulum OBE di program studi  "],

            ["id" => "2", "name" => "1.Terdapat profil lulusan pada program studi yang dituangkan dalam Buku Kurikulum"],

            ["id" => "3", "name" => "1. Terdapat capaian pembelajran lulusan di buku kurikulum
                                    2. Pembebanan CPL ke CPMK dilihat dari RPS"],

            ["id" => "4", "name" => "1. VMTS Program Studi
                                    2. VMTS berkaitan dengan Profil Lulusan dan Keilmuan"],

            ["id" => "6", "name" => "1.SK atau Surat Tugas tim perumus kurikulum"],

            ["id" => "5", "name" => "1.SK atau pengesahan CPL"],

            ["id" => "7", "name" => "1. Jumlah lulusan smt ganjil dan rata2 IPKnya?
                                    2. Jumlah lulusan smt genap dan rata2 IPKnya?"],

            ["id" => "8", "name" => "1. Data masa tunggu lulusan pada TS-1 (TA 2021/2022)
                                    2. Data masa tunggu lulusan pada TS-2 (TA 2020/2021)
                                    3. Data masa tunggu lulusan pada TS-3 (TA 2019/2020)
                                    4. Data masa tunggu lulusan pada TS-4 (TA 2018/2019)"],

            ["id" => "9", "name" => "1. Data kesesuaian bidang kerja lulusan pada TS-1 (TA 2021/2022)
                                    2. Data kesesuaian bidang kerja lulusan pada TS-2 (TA 2020/2021)
                                    3. Data kesesuaian bidang kerja lulusan pada TS-3 (TA 2019/2020)
                                    4. Data kesesuaian bidang kerja lulusan pada TS-4 (TA 2018/2019)"],
        ];

        foreach ($data as $x) {
            if(!SubIndicator::where('id', $x['id'])->first()){
                $m = new SubIndicator();
                $m->id = $x['id'];
                $m->name = $x['name'];
                $m->save();
            }
        }
    }
}

