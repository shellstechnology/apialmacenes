<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Lugares_EntregaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Lugares_Entrega::factory(1)->create([
            "longitud" => "99",
            "latitud" => "99",
            "direccion" => "La vieja china",
        ]);
        \App\Models\Lugares_Entrega::factory(1)->create([
            "longitud" => "120",
            "latitud" => "30",
            "direccion" => "mi casita",
        ]);
        \App\Models\Lugares_Entrega::factory(1)->create([
            "longitud" => "47",
            "latitud" => "47",
            "direccion" => "almacen 47 listar",
        ]);
        \App\Models\Lugares_Entrega::factory(1)->create([
            "longitud" => "42",
            "latitud" => "42",
            "direccion" => "almacen 42 modificar",
        ]);
        \App\Models\Lugares_Entrega::factory(1)->create([
            "longitud" => "74",
            "latitud" => "74",
            "direccion" => "almacen 74 eliminar",
        ]);
    }
}
