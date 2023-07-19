<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Paquete::factory(10) -> create();
        \App\Models\Lote::factory(10) -> create();
        \App\Models\Paquete::factory(1) -> create([
            "id" => "47",
            "nombre" => "quesos cremosos",
            "nombre_del_remitente" => "vegetta777"]);
    }
}
