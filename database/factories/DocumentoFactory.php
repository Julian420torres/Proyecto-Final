<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tipo_documento' => $this->faker->randomElement(['DNI', 'Pasaporte', 'Cédula']),
        ];
    }
}
