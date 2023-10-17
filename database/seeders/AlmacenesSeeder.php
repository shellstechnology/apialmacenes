<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlmacenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Almacenes::factory(1)->create([
            "id" => "47",
            "id_lugar_entrega" => "3",
        ]);
        \App\Models\Almacenes::factory(1)->create([
            "id" => "74",
            "id_lugar_entrega" => "3",
        ]);
        \App\Models\Almacenes::factory(1)->create([
            "id" => "42",
            "id_lugar_entrega" => "3",
        ]);
    }
}
