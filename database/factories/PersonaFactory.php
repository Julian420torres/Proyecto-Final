<?php

namespace Database\Factories;

use App\Models\Documento;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'razon_social' => $this->faker->name,
            'direccion' => $this->faker->address,
            'tipo_persona' => $this->faker->randomElement(['natural', 'juridica']),
            'documento_id' => Documento::factory(),
            'numero_documento' => $this->faker->numerify('#########'),
        ];
    }
}
