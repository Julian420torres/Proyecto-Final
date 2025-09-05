<?php

namespace Database\Factories;

use App\Models\Persona;
use App\Models\Documento;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonaFactory extends Factory
{
    protected $model = Persona::class;

    public function definition(): array
    {
        return [
            'razon_social' => $this->faker->company,
            'direccion'    => $this->faker->address,
            'tipo_persona' => $this->faker->randomElement(['Cliente', 'Proveedor']),
            'estado'       => 1,
            'documento_id' => Documento::factory(), // 🔗 crea documento asociado
        ];
    }
}
