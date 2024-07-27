<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            ["id" => "HODLPM", "title" => "Ariep Jaenul, S.Pd. M.Sc.Eng", "content" => "S092019030004"],
            ["id" => "HODBPMI", "title" => "Arisa Olivia P., S.S.T., MIT", "content" => "S092019030009"],
        ];

        foreach ($data as $x) {
            if(!Setting::where('id', $x['id'])->first()){
                $m = new Setting();
                $m->id = $x['id'];
                $m->title = $x['title'];
                $m->content = $x['content'];
                $m->save();
            }
        }
    }
}
