<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Caracteristica;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    public function definition(): array
    {
        return [
            'caracteristica_id' => Caracteristica::factory(),
        ];
    }
}
