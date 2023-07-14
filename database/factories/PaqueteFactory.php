<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paquete>
 */
class PaqueteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'estado' => $this->faker->numberBetween(1, 10),
            'volumen_l' => $this->faker->numberBetween(1, 100),
            'peso_kg' => $this->faker->numberBetween(1,100),
            'tipo_paquete' => $this->faker->numberBetween(1,100),
            'nombre_del_destinatario' => $this->faker->name(),
            'nombre_del_remitente' => $this->faker->name(),
            'fecha_de_entrega' => $this->faker->dateTime(),
        ];
    }
}
