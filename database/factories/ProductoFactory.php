<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->bothify('P###'),
            'nombre' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'fecha_vencimiento' => $this->faker->dateTimeBetween('+1 week', '+1 year'),
            'img_path' => 'productos/default.jpg',
            'estado' => 1,
        ];
    }
}
