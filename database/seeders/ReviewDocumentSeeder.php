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
            "name" => "- Laporan pelaksanaan PkM",
            "standard_criteria_id" => "4",
            "standard_statement_id" => "141"],
            ["id" => "2",
            "name" => "- Rubrik/Form reviewer",
            "standard_criteria_id" => "4",
            "standard_statement_id" => "142"],
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
