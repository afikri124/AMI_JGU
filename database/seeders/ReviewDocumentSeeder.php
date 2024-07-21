<?php

namespace Database\Seeders;

use App\Models\Indicator;
use App\Models\ReviewDocs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File as FacadesFile;


class ReviewDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ["id" => "1",
            "name" => "1. Surat Undangan Mitra 2. Hasil rapat atau berita acara lokakarya kurikulum 3. Pengesahan kurikulum",
"standard_criteria_id" => "1",
"standard_statement_id" => "1"],

            ["id" => "2",
            "name" => "Buku kurikulum",
            "standard_criteria_id" => "1",
            "standard_statement_id" => "2"],

            ["id" => "3",
            "name" => "1. Buku Kurikulum yang memuat CPL 2. CPMK untuk di RPS",
"standard_criteria_id" => "1",
"standard_statement_id" => "3"],

            ["id" => "4",
            "name" => "1. VMTS Prodi 2. Profil Lulusan dan Keilmuan di Prodi",
"standard_criteria_id" => "1",
"standard_statement_id" => "4"],

            ["id" => "5",
            "name" => "SK atau Surat Tugas",
            "standard_criteria_id" => "1",
            "standard_statement_id" => "5"],

            ["id" => "6",
            "name" => "Buku Kurikulum",
            "standard_criteria_id" => "1",
            "standard_statement_id" => "6"],

            ["id" => "7",
            "name" => "Data lulusan smt ganjil dan genap / Surat Keputusannya",
            "standard_criteria_id" => "1",
            "standard_statement_id" => "7"],

            ["id" => "8",
            "name" => "Laporan hasil tracer study",
            "standard_criteria_id" => "1",
            "standard_statement_id" => "8"],

            ["id" => "9",
            "name" => "1. Restra dan Renop penelitian 2. List Penelitian Dosen 3. List Penelitian Mahasiswa",
"standard_criteria_id" => "9",
"standard_statement_id" => "10"],

            ["id" => "10",
            "name" => "1. Sample proposal penelitian dan laporan akhir penelitian 2. Roadmap penelitian Program Studi",
"standard_criteria_id" => "9",
"standard_statement_id"=> "11"]
        ];

        foreach ($data as $x) {
            if(!ReviewDocs::where('id', $x['id'])->first()){
                $m = new ReviewDocs();
                $m->id = $x['id'];
                $m->name = $x['name'];
                $m->standard_criteria_id = $x['standard_criteria_id'];
                $m->standard_statement_id = $x['standard_statement_id'];
                $m->save();
            }
        }
    }
}
