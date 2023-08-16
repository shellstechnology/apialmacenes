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
            'volumen_l' => $this->faker->numberBetween(1, 10),
            'peso_kg' => $this->faker->numberBetween(1,10),
            'id_estado_p' => $this->faker->numberBetween(1, 3),
            'id_caracteristica_paquete' => $this->faker->numberBetween(1, 4),
            'id_producto' => $this->faker->numberBetween(1, 4),
            'id_lugar_entrega' => $this->faker->numberBetween(1, 2),
            'nombre_destinatario' => $this->faker->name(),
            'nombre_remitente' => $this->faker->name(),
            'fecha_de_entrega' => $this->faker->dateTime(),
        ];
    }
}
