<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Descripcion_Caracteristica_PaqueteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Caracteristica::factory(1)->create([
            "descripcion_caracteristica" => "comestible",
        ]);
        \App\Models\Caracteristica::factory(1)->create([
            "descripcion_caracteristica" => "electronicos",
        ]);
        \App\Models\Caracteristica::factory(1)->create([
            "descripcion_caracteristica" => "inflamable",
        ]);
        \App\Models\Caracteristica::factory(1)->create([
            "descripcion_caracteristica" => "explosivo",
        ]);
    }
}
