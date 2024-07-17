<?php

// database/seeders/StandardCriteriaSeeder.php

namespace Database\Seeders;

use App\Models\StandardCriteria;
use Illuminate\Database\Seeder;

class StandardCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ["id" => "1", "title" => "Standar Kompetensi Lulusan", "standard_category_id" => "1", "status" => true],
            ["id" => "2", "title" => "Standar Dosen & Tenaga Kependidikan", "standard_category_id" => "1", "status" => true],
            ["id" => "3", "title" => "Standar Isi Pembelajaran", "standard_category_id" => "1", "status" => true],
            ["id" => "4", "title" => "Standar Proses Pembelajaran", "standard_category_id" => "1", "status" => true],
            ["id" => "5", "title" => "Standar Pengelolaan Pembelajaran", "standard_category_id" => "1", "status" => true],
            ["id" => "6", "title" => "Standar Penilaian Pembelajaran", "standard_category_id" => "1", "status" => true],
            ["id" => "7", "title" => "Standar Sarana Dan Prasarana Pembelajaran", "standard_category_id" => "1", "status" => true],
            ["id" => "8", "title" => "Standar Pembiayaan Pembelajaran", "standard_category_id" => "1", "status" => true],
            ["id" => "9", "title" => "STANDAR HASIL PENELITIAN", "standard_category_id" => "2", "status" => true],
            ["id" => "10", "title" => "STANDAR ISI PENELITIAN", "standard_category_id" => "2", "status" => true],
            ["id" => "11", "title" => "STANDAR PROSES PENELITIAN", "standard_category_id" => "2", "status" => true],
            ["id" => "12", "title" => "STANDAR PENILAIAN PENELITIAN", "standard_category_id" => "2", "status" => true],
            ["id" => "13", "title" => "STANDAR PENELITI", "standard_category_id" => "2", "status" => true],
            ["id" => "14", "title" => "STANDAR SARANA DAN PRASARANA PENELITIAN", "standard_category_id" => "2", "status" => true],
            ["id" => "15", "title" => "STANDAR PENGELOLAAN PENELITIAN", "standard_category_id" => "2", "status" => true],
            ["id" => "16", "title" => "STANDAR PENDANAAN PENELITIAN", "standard_category_id" => "2", "status" => true]
        ];

        foreach ($data as $x) {
            if(!StandardCriteria::where('id', $x['id'])->first()){
                $m = new StandardCriteria();
                $m->id = $x['id'];
                $m->title = $x['title'];
                $m->standard_category_id = $x['standard_category_id'];
                $m->status = $x['status'];
                $m->save();
            }
        }
    }
}
