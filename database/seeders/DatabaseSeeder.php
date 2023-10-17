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
        $this->call(MonedaSeeder::class);
        $this->call(ProductoSeeder::class); 
        $this->call(Descripcion_Caracteristica_PaqueteSeeder::class);
        $this->call(Estados_PSeeder::class);
        $this->call(Lugares_EntregaSeeder::class);
        $this->call(PaqueteSeeder::class);
        $this->call(LoteSeeder::class);
        $this->call(AlmacenesSeeder::class);
        $this->call(Paquete_Contiene_LoteSeeder::class);
    }
}
