<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;
use Illuminate\Support\Facades\File;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::truncate();
        $json = File::get("database/data/room.json");
        $loc = json_decode($json);
  
        foreach ($loc as $key => $value) {
            Location::create([
                "id" => $value->id,
                "title" => $value->title
            ]);
        }
    }
}
