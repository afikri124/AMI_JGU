<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File as FacadesFile;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    //     Dosen::truncate();
    //     $json = FacadesFile::get("database/data/dosen.json");
    //     $loc = json_decode($json);

    //     foreach ($loc as $key => $value) {
    //         Dosen::create([
    //             "id" => $value->id,
    //             "name" => $value->name,
    //             "back"=> $value->back,
    //             "email" => $value->email,
    //             "hp" => $value->hp
    //         ]);
    // }
}
}