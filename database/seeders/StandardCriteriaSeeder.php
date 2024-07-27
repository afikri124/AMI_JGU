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
            ["id" => "1", "title" => "Standar Hasil Kompetensi Lulusan", "standard_category_id" => "1", "status" => true],
            ["id" => "2", "title" => "Standar Isi Pembelajaran", "standard_category_id" => "1", "status" => true],
            ["id" => "3", "title" => "Standar Proses Pembelajaran", "standard_category_id" => "1", "status" => true],
            ["id" => "4", "title" => "Standar Penilaian Pembelajaran", "standard_category_id" => "1", "status" => true],
            ["id" => "5", "title" => "Standar Dosen dan Tenaga Kependidikan", "standard_category_id" => "1", "status" => true],
            ["id" => "6", "title" => "Standar Sarana dan Prasarana Pembelajaran", "standard_category_id" => "1", "status" => true],
            ["id" => "7", "title" => "Standar Pengelolaan Pembelajaran", "standard_category_id" => "1", "status" => true],
            ["id" => "8", "title" => "Standar Pembiayaan Pembelajaran", "standard_category_id" => "1", "status" => true],
            ["id" => "9", "title" => "STANDAR HASIL PENELITIAN", "standard_category_id" => "2", "status" => true],
            ["id" => "10", "title" => "STANDAR ISI PENELITIAN", "standard_category_id" => "2", "status" => true],
            ["id" => "11", "title" => "STANDAR PROSES PENELITIAN", "standard_category_id" => "2", "status" => true],
            ["id" => "12", "title" => "STANDAR PENILAIAN PENELITIAN", "standard_category_id" => "2", "status" => true],
            ["id" => "13", "title" => "STANDAR PENELITI", "standard_category_id" => "2", "status" => true],
            ["id" => "14", "title" => "STANDAR SARANA DAN PRASARANA PENELITIAN", "standard_category_id" => "2", "status" => true],
            ["id" => "15", "title" => "STANDAR PENGELOLAAN PENELITIAN", "standard_category_id" => "2", "status" => true],
            ["id" => "16", "title" => "STANDAR PENDANAAN PENELITIAN", "standard_category_id" => "2", "status" => true],
            ["id" => "17", "title" => "STANDAR HASIL PENGABDIAN MASYARAKAT", "standard_category_id" => "3", "status" => true],
            ["id" => "18", "title" => "STANDAR ISI PENGABDIAN MASYARAKAT", "standard_category_id" => "3", "status" => true],
            ["id" => "19", "title" => "STANDAR PROSES PENGABDIAN MASYARAKAT", "standard_category_id" => "3", "status" => true],
            ["id" => "20", "title" => "STANDAR PENILAIAN PENGABDIAN MASYARAKAT", "standard_category_id" => "3", "status" => true],
            ["id" => "21", "title" => "STANDAR PELAKSANA ABDIMAS", "standard_category_id" => "3", "status" => true],
            ["id" => "22", "title" => "STANDAR SARANA DAN PRASARANA ABDIMAS", "standard_category_id" => "3", "status" => true],
            ["id" => "23", "title" => "STANDAR PENGELOLAAN ABDIMAS", "standard_category_id" => "3", "status" => true],
            ["id" => "24", "title" => "STANDAR PENDANAAN PENGABDIAN KEPADA MASYARAKAT", "standard_category_id" => "3", "status" => true],
            ["id" => "25", "title" => "Standar Kebijakan Tata Pamong dan Tata Kelola", "standard_category_id" => "4", "status" => true],
            ["id" => "26", "title" => "Standar pelaksanaan Tata Pamong Tata Kelola", "standard_category_id" => "4", "status" => true],
            ["id" => "27", "title" => "Standar Penerimaan Mahasiswa Baru", "standard_category_id" => "4", "status" => true],
            ["id" => "28", "title" => "Standar Lembaga Kemahasiswaan", "standard_category_id" => "4", "status" => true],
            ["id" => "29", "title" => "Standar Sarana dan Prasarana Kegiatan Kemahasiswaan", "standard_category_id" => "4", "status" => true],
            ["id" => "30", "title" => "Standar Pembiayaan Kegiatan Mahasiswa", "standard_category_id" => "4", "status" => true],
            ["id" => "31", "title" => "Standar Penghargaan dan Prestasi Mahasiswa", "standard_category_id" => "4", "status" => true],
            ["id" => "32", "title" => "Standar Lembaga Kerja sama", "standard_category_id" => "4", "status" => true],
            ["id" => "33", "title" => "Standar Prosedur Pelaksanaan Kegiatan kerja sama", "standard_category_id" => "4", "status" => true],
            ["id" => "34", "title" => "Standar Tupoksi Jobdesc Tata Pamong dan Tata Kelola JGU", "standard_category_id" => "4", "status" => true],
            ["id" => "35", "title" => "Standar Persiapan Perkuliahan", "standard_category_id" => "4", "status" => true],
            ["id" => "36", "title" => "Standar Pelaksanaan Ujian", "standard_category_id" => "4", "status" => true]
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
