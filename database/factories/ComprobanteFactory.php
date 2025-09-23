<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ComprobanteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tipo_comprobante' => $this->faker->randomElement(['Factura', 'Boleta']),
            'estado' => 1, // o $this->faker->boolean() si quieres variarlo
        ];
    }
}
