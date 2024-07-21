<?php

namespace Database\Seeders;

use App\Models\Indicator;
use App\Models\SubIndicator;
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
            ["id" => "1",
            "name" => "1. Terdapat pedoman perumusan capaian pembelajaran
2. Rancangan kurikulum OBE di program studi",
"standard_criteria_id" => "1",
"standard_statement_id" => "1"],

            ["id" => "2",
            "name" => "Terdapat profil lulusan pada program studi yang dituangkan dalam Buku Kurikulum",
"standard_criteria_id" => "1",
            "standard_statement_id" => "2"],

            ["id" => "3",
            "name" => "1. Terdapat capaian pembelajran lulusan di buku kurikulum
2. Pembebanan CPL ke CPMK dilihat dari RPS",
"standard_criteria_id" => "1",
"standard_statement_id" => "3"],

            ["id" => "4",
            "name" => "1. VMTS Program Studi
2. VMTS berkaitan dengan Profil Lulusan dan Keilmuan",
"standard_criteria_id" => "1",
"standard_statement_id" => "4"],

            ["id" => "5",
            "name" => "SK atau Surat Tugas tim perumus kurikulum",
"standard_criteria_id" => "1",
            "standard_statement_id" => "5"],

            ["id" => "6",
            "name" => "SK atau pengesahan CPL",
"standard_criteria_id" => "1",
            "standard_statement_id" => "6"],

            ["id" => "7",
            "name" => "1. Jumlah lulusan smt ganjil dan rata2 IPKnya?
2. Jumlah lulusan smt genap dan rata2 IPKnya?",
"standard_criteria_id" => "1",
"standard_statement_id" => "7"],

            ["id" => "8",
            "name" => "1. Data masa tunggu lulusan pada TS-1 (TA 2021/2022)
2. Data masa tunggu lulusan pada TS-2 (TA 2020/2021)
3. Data masa tunggu lulusan pada TS-3 (TA 2019/2020)
4. Data masa tunggu lulusan pada TS-4 (TA 2018/2019)",
"standard_criteria_id" => "1",
"standard_statement_id" => "8"],

            ["id" => "9",
            "name" => "1. Data kesesuaian bidang kerja lulusan pada TS-1 (TA 2021/2022)
2. Data kesesuaian bidang kerja lulusan pada TS-2 (TA 2020/2021)
3. Data kesesuaian bidang kerja lulusan pada TS-3 (TA 2019/2020)
4. Data kesesuaian bidang kerja lulusan pada TS-4 (TA 2018/2019)",
"standard_criteria_id" => "1",
"standard_statement_id" => "9"],

            ["id" => "10",
            "name" => "1. Jumlah penelitian dosen yang dipublikasikan (spesifik-kan untuk jenis publikasinya dalam TA 2022/2023?
2. Jumlah penelitian mahasiswa yang dipublikasikan (spesifik-kan untuk jenis publikasinya dalam TA 2022/2023?",
"standard_criteria_id" => "9",
"standard_statement_id" => "10"],

            ["id" => "11",
            "name" => "1. Hasil penelitian sesuai dengan pedoman penelitian?
2. Terdapat road map penelitian di dalam buku pedoman penelitian?",
"standard_criteria_id" => "9",
"standard_statement_id"=> "11"]
        ];

        foreach ($data as $x) {
            if(!Indicator::where('id', $x['id'])->first()){
                $m = new Indicator();
                $m->id = $x['id'];
                $m->name = $x['name'];
                $m->standard_criteria_id = $x['standard_criteria_id'];
                $m->standard_statement_id = $x['standard_statement_id'];
                $m->save();
            }
        }
    }
}
