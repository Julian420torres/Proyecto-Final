<?php

namespace Database\Factories;

use App\Models\Documento;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentoFactory extends Factory
{
    protected $model = Documento::class;

    public function definition(): array
    {
        return [
            'tipo_documento'   => $this->faker->randomElement(['DNI', 'RUC', 'Pasaporte']),
            'numero_documento' => $this->faker->unique()->numerify('########'), // 8 dígitos aleatorios
        ];
    }
}
