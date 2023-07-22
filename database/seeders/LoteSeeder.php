<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Lote::factory(9) -> create();
        \App\Models\Lote::factory(1) -> create([
            "id" => "47",
            "lote_id_paquete" => "47"]);
    }
}
