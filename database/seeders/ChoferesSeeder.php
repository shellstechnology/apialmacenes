<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChoferesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\choferes::factory(1)->create([
            "id_usuarios"=>"10",
            "licencia_de_conducir" => "ninguna",
        ]);
        \App\Models\choferes::factory(1)->create([
            "id_usuarios"=>"20",
            "licencia_de_conducir" => "licencia",
        ]);
        \App\Models\choferes::factory(1)->create([
            "id_usuarios"=>"47",
            "licencia_de_conducir" => "lic list",
        ]);
        \App\Models\choferes::factory(1)->create([
            "id_usuarios"=>"42",
            "licencia_de_conducir" => "lic mod",
        ]);
        \App\Models\choferes::factory(1)->create([
            "id_usuarios"=>"74",
            "licencia_de_conducir" => "lic del",
        ]);
    }
}
