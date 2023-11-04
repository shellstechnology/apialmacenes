<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class MonedasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        \App\Models\moneda::factory(1)->create([
            "moneda" => "pesos uruguayos",
        ]);
        \App\Models\moneda::factory(1)->create([
            "moneda" => "dolares",
        ]);
        \App\Models\moneda::factory(1)->create([
            "moneda" => "reales",
        ]);
    }
  
}
