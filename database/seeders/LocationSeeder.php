<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;
use Illuminate\Support\Facades\File as FacadesFile;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Location::truncate();
        $json = FacadesFile::get("database/data/room.json");
        $loc = json_decode($json);

        foreach ($loc as $key => $value) {
            Location::create([
                "id" => $value->id,
                "title" => $value->title
            ]);
        }
    }
}
