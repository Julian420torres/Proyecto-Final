<?php

namespace Database\Factories;

use App\Models\Caracteristica;
use Illuminate\Database\Eloquent\Factories\Factory;

class CaracteristicaFactory extends Factory
{
    protected $model = Caracteristica::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'estado' => 1, // activo por defecto
        ];
    }
}
